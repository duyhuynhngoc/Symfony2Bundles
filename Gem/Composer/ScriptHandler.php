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
use Sensio\Bundle\GeneratorBundle\Command\Helper;
use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
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


    public static function updateKernel(CommandEvent $event)
    {
        require_once static::$options['symfony-app-dir'] . '/AppKernel.php';

        $auto = true;
        $kernel = new \AppKernel("dev", true);
        $manip = new KernelManipulator($kernel);
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $questionHelper = new Helper\QuestionHelper();

        try {

            $bundles = static::findBundle();

            foreach ($bundles as $bundle) {
                $namespace = static::getNamespace($bundle);
                $bundleName = static::getBundleName($bundle);

                if (!static::existsBundle($namespace, $bundleName))
                    continue;

                $agree = true;
                if ($input->isInteractive()) {
                    $text = 'Confirm registration <fg=white;options=bold>' . $bundleName . '</> bundle';
                    $question = new ConfirmationQuestion($questionHelper->getQuestion($text, 'yes', '?'), true);
                    $agree = $questionHelper->ask($input, $output, $question);
                }
                $ret = true;
                try {
                    $ret = $agree ? $manip->addBundle($namespace . '\\' . $bundleName) : false;
                } catch (\Exception $e) {}

                if (!$ret) {
                    $reflected = new \ReflectionObject($kernel);
                } else {
                    self::updateRouting($namespace, $bundleName);
                    $output->writeln('<fg=green;options=bold>Successful!</>');
                }


            }
        }catch(\Exception $e){
            $output->writeln('<fg=red>'.$e->getMessage().'</>');
        }
    }

    protected static function updateRouting($namespace, $bundle, $format = "yml")
    {
        $routing = new RoutingManipulator(static::$options['symfony-app-dir'].'/config/routing.yml');

        $file = __DIR__.'/../'.$namespace.'/Resources/config/routing.'.$format;

        if(file_exists($file)){
            $routing->addResource($bundle, $format);
        }
    }


    public static function removeBundle()
    {

    }

    protected static function findBundle()
    {
        $bundles = array();

        $finder = new Finder();

        $finder->depth(0)->directories()->in(__DIR__."/../");

        foreach ($finder as $dir) {
            $bundleName = $dir->getRelativePathname();

            if($bundleName == "Composer")
                continue;
            $bundles[] = $bundleName;
        }

        return $bundles;
    }

    protected static function getNamespace($bundle)
    {
        return dirname(__NAMESPACE__)."\\".$bundle;
    }

    protected static function getBundleName($bundle)
    {
        $name = str_replace("\\", "", dirname(__NAMESPACE__));
        return $name.$bundle;
    }


    protected static function existsBundle($namespace ,$bundleName)
    {
        $cls = $namespace."\\".$bundleName;

        if(!class_exists($cls)){
            return false;
        }

        return true;
    }

    protected static function hasDirectory(CommandEvent $event, $configName, $path, $actionName)
    {
        if (!is_dir($path)) {
            $event->getIO()->write(sprintf('The %s (%s) specified in composer.json was not found in %s, can not %s.', $configName, $path, getcwd(), $actionName));

            return false;
        }

        return true;
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

}
