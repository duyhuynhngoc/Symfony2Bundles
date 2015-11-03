<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gem\Composer;

use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\CommandEvent;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ScriptHandler
{
    /**
     * Composer variables are declared static so that an event could update
     * a composer.json and set new options, making them immediately available
     * to forthcoming listeners.
     */
    protected static $options = array(
        'symfony-app-dir' => 'app',
        'symfony-web-dir' => 'web',
        'symfony-assets-install' => 'hard',
        'symfony-cache-warmup' => false,
    );


    protected static function hasDirectory(CommandEvent $event, $configName, $path, $actionName)
    {
        if (!is_dir($path)) {
            $event->getIO()->write(sprintf('The %s (%s) specified in composer.json was not found in %s, can not %s.', $configName, $path, getcwd(), $actionName));

            return false;
        }

        return true;
    }


    protected static function prepareDeploymentTargetHeroku(CommandEvent $event)
    {
        $options = static::getOptions($event);
        if (($stack = getenv('STACK')) && ($stack == 'cedar' || $stack == 'cedar-14')) {
            $fs = new Filesystem();
            if (!$fs->exists('Procfile')) {
                $event->getIO()->write('Heroku deploy detected; creating default Procfile for "web" dyno');
                $fs->dumpFile('Procfile', sprintf('web: $(composer config bin-dir)/heroku-php-apache2 %s/', $options['symfony-web-dir']));
            }
        }
    }

    /**
     * Clears the Symfony cache.
     *
     * @param $event CommandEvent A instance
     */
    public static function clearCache(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'clear the cache');

        if (null === $consoleDir) {
            return;
        }

        $warmup = '';
        if (!$options['symfony-cache-warmup']) {
            $warmup = ' --no-warmup';
        }

        static::executeCommand($event, $consoleDir, 'cache:clear'.$warmup, $options['process-timeout']);
    }

    /**
     * Installs the assets under the web root directory.
     *
     * For better interoperability, assets are copied instead of symlinked by default.
     *
     * Even if symlinks work on Windows, this is only true on Windows Vista and later,
     * but then, only when running the console with admin rights or when disabling the
     * strict user permission checks (which can be done on Windows 7 but not on Windows
     * Vista).
     *
     * @param $event CommandEvent A instance
     */
    public static function installAssets(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'install assets');

        if (null === $consoleDir) {
            return;
        }

        $webDir = $options['symfony-web-dir'];

        $symlink = '';
        if ($options['symfony-assets-install'] == 'symlink') {
            $symlink = '--symlink ';
        } elseif ($options['symfony-assets-install'] == 'relative') {
            $symlink = '--symlink --relative ';
        }

        if (!static::hasDirectory($event, 'symfony-web-dir', $webDir, 'install assets')) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'assets:install '.$symlink.escapeshellarg($webDir), $options['process-timeout']);
    }



    public static function updateKernel(CommandEvent $event)
    {
        require_once static::$options['symfony-app-dir'].'/AppKernel.php';
        require_once static::$options['symfony-app-dir'].'/bootstrap.php.cache';

        try {
            $kernel = new AppKernel("dev", true);
            var_dump("oooook");
            #$application = new Application($kernel);

            $manip = new KernelManipulator($kernel);
        }catch (\Exception $e){
            var_dump("ajsdjaljdsajdjsalj");
        }
    }



    protected static function executeCommand(CommandEvent $event, $consoleDir, $cmd, $timeout = 300)
    {
        $php = escapeshellarg(static::getPhp(false));
        $phpArgs = implode(' ', array_map('escapeshellarg', static::getPhpArguments()));
        $console = escapeshellarg($consoleDir.'/console');
        if ($event->getIO()->isDecorated()) {
            $console .= ' --ansi';
        }

        $process = new Process($php.($phpArgs ? ' '.$phpArgs : '').' '.$console.' '.$cmd, null, null, null, $timeout);
        $process->run(function ($type, $buffer) use ($event) { $event->getIO()->write($buffer, false); });
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf('An error occurred when executing the "%s" command.', escapeshellarg($cmd)));
        }
    }

    protected static function executeBuildBootstrap(CommandEvent $event, $bootstrapDir, $autoloadDir, $timeout = 300)
    {
        $php = escapeshellarg(static::getPhp(false));
        $phpArgs = implode(' ', array_map('escapeshellarg', static::getPhpArguments()));
        $cmd = escapeshellarg(__DIR__.'/../Resources/bin/build_bootstrap.php');
        $bootstrapDir = escapeshellarg($bootstrapDir);
        $autoloadDir = escapeshellarg($autoloadDir);
        $useNewDirectoryStructure = '';
        if (static::useNewDirectoryStructure(static::getOptions($event))) {
            $useNewDirectoryStructure = escapeshellarg('--use-new-directory-structure');
        }

        $process = new Process($php.($phpArgs ? ' '.$phpArgs : '').' '.$cmd.' '.$bootstrapDir.' '.$autoloadDir.' '.$useNewDirectoryStructure, getcwd(), null, null, $timeout);
        $process->run(function ($type, $buffer) use ($event) { $event->getIO()->write($buffer, false); });
        if (!$process->isSuccessful()) {
            throw new \RuntimeException('An error occurred when generating the bootstrap file.');
        }
    }

    protected static function updateDirectoryStructure(CommandEvent $event, $rootDir, $appDir, $binDir, $varDir, $webDir)
    {
        $event->getIO()->write('Updating Symfony directory structure...');

        $fs = new Filesystem();

        $fs->mkdir(array($binDir, $varDir));

        foreach (array(
            $appDir.'/console' => $binDir.'/console',
            $appDir.'/phpunit.xml.dist' => $rootDir.'/phpunit.xml.dist',
        ) as $source => $target) {
            $fs->rename($source, $target, true);
        }

        foreach (array('/logs', '/cache') as $dir) {
            $fs->rename($appDir.$dir, $varDir.$dir);
        }

        $gitignore = <<<EOF
/web/bundles/
/app/config/parameters.yml
/var/bootstrap.php.cache
/var/SymfonyRequirements.php
/var/cache/*
/var/logs/*
!var/cache/.gitkeep
!var/logs/.gitkeep
/build/
/vendor/
/bin/*
!bin/console
!bin/symfony_requirements
/composer.phar
EOF;
        $phpunitKernelBefore = <<<EOF
    <!--
    <php>
        <server name="KERNEL_DIR" value="/path/to/your/app/" />
    </php>
    -->
EOF;
        $phpunitKernelAfter = <<<EOF
    <php>
        <server name="KERNEL_DIR" value="$appDir/" />
    </php>
EOF;
        $phpunit = str_replace(array('<directory>../src', '"bootstrap.php.cache"', $phpunitKernelBefore), array('<directory>src', '"'.$varDir.'/bootstrap.php.cache"', $phpunitKernelAfter), file_get_contents($rootDir.'/phpunit.xml.dist'));
        $composer = str_replace('"symfony-app-dir": "app",', "\"symfony-app-dir\": \"app\",\n        \"symfony-bin-dir\": \"bin\",\n        \"symfony-var-dir\": \"var\",", file_get_contents($rootDir.'/composer.json'));

        $fs->dumpFile($webDir.'/app.php', str_replace($appDir.'/bootstrap.php.cache', $varDir.'/bootstrap.php.cache', file_get_contents($webDir.'/app.php')));
        $fs->dumpFile($webDir.'/app_dev.php', str_replace($appDir.'/bootstrap.php.cache', $varDir.'/bootstrap.php.cache', file_get_contents($webDir.'/app_dev.php')));
        $fs->dumpFile($binDir.'/console', str_replace(array(".'/bootstrap.php.cache'", ".'/AppKernel.php'"), array(".'/".$fs->makePathRelative($varDir, $binDir)."bootstrap.php.cache'", ".'/".$fs->makePathRelative($appDir, $binDir)."AppKernel.php'"), file_get_contents($binDir.'/console')));
        $fs->dumpFile($rootDir.'/phpunit.xml.dist', $phpunit);
        $fs->dumpFile($rootDir.'/composer.json', $composer);

        $fs->dumpFile($rootDir.'/.gitignore', $gitignore);

        $fs->chmod($binDir.'/console', 0755);
    }

    protected static function getOptions(CommandEvent $event)
    {
        $options = array_merge(static::$options, $event->getComposer()->getPackage()->getExtra());

        $options['symfony-assets-install'] = getenv('SYMFONY_ASSETS_INSTALL') ?: $options['symfony-assets-install'];

        $options['process-timeout'] = $event->getComposer()->getConfig()->get('process-timeout');

        return $options;
    }

    protected static function getPhp($includeArgs = true)
    {
        $phpFinder = new PhpExecutableFinder();
        if (!$phpPath = $phpFinder->find($includeArgs)) {
            throw new \RuntimeException('The php executable could not be found, add it to your PATH environment variable and try again');
        }

        return $phpPath;
    }

    protected static function getPhpArguments()
    {
        $arguments = array();

        $phpFinder = new PhpExecutableFinder();
        if (method_exists($phpFinder, 'findArguments')) {
            $arguments = $phpFinder->findArguments();
        }

        if (false !== $ini = php_ini_loaded_file()) {
            $arguments[] = '--php-ini='.$ini;
        }

        return $arguments;
    }

    /**
     * Returns a relative path to the directory that contains the `console` command.
     *
     * @param CommandEvent $event      The command event.
     * @param string       $actionName The name of the action
     *
     * @return string|null The path to the console directory, null if not found.
     */
    protected static function getConsoleDir(CommandEvent $event, $actionName)
    {
        $options = static::getOptions($event);

        if (static::useNewDirectoryStructure($options)) {
            if (!static::hasDirectory($event, 'symfony-bin-dir', $options['symfony-bin-dir'], $actionName)) {
                return;
            }

            return $options['symfony-bin-dir'];
        }

        if (!static::hasDirectory($event, 'symfony-app-dir', $options['symfony-app-dir'], 'execute command')) {
            return;
        }

        return $options['symfony-app-dir'];
    }

    /**
     * Returns true if the new directory structure is used.
     *
     * @param array $options Composer options
     *
     * @return bool
     */
    protected static function useNewDirectoryStructure(array $options)
    {
        return isset($options['symfony-var-dir']) && is_dir($options['symfony-var-dir']);
    }
}
