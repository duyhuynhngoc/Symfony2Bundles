<?php

/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 11/03/2015
 * Modified by: Duy Huynh
 */

namespace Gem\Scripts;

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
 * This class only used to deployment Ccicore library.
 * Class ScriptHandler
 * @package Ccicore\Scripts
 */

/**
 * Usage: This class run in script of composer
 *  "post-install-cmd": [
 *      "Ccicore\\Scripts\\ScriptHandler::updateKernel"
 *   ],
 *   "post-update-cmd": [
 *      "Ccicore\\Scripts\\ScriptHandler::updateKernel"
 *   ]
 *
 */
class ScriptHandler
{
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
                    self::updateRouting($bundle, $bundleName);
                    $output->writeln('<fg=green;options=bold>Successful!</>');
                }


            }
        }catch(\Exception $e){
            $output->writeln('<fg=red>'.$e->getMessage().'</>');
        }
    }

    protected static function updateRouting($bundle, $bundleName, $format = "yml")
    {
        $routing = new RoutingManipulator(static::$options['symfony-app-dir'].'/config/routing.yml');

        $file = __DIR__.'/../'.$bundle.'/Resources/config/routing.'.$format;
        var_dump($file);

        if(file_exists($file)){
            $routing->addResource($bundleName, $format);
        }
    }

    protected static function findBundle()
    {
        $bundles = array();

        $finder = new Finder();

        $finder->depth(0)->directories()->in(__DIR__."/../");

        foreach ($finder as $dir) {
            $bundleName = $dir->getRelativePathname();

            if($bundleName == "Scripts")
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
}
