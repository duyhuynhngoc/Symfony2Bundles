<?php
/**
 * Modified date: 10/28/2015
 * Modified by: Duy Huynh
 */

namespace Gem\ConfigurationBundle\Lib;

class Configuration {

    public static function getConfig($key)
    {
        $keys = explode(".", $key);

        $configData = self::getConfigurationData()['configs'];

        foreach($keys as $key){
            if(isset($configData[$key])){
                $configData = $configData[$key];
            }else{
                $configData = null;
                break;
            }
        }

        return $configData;
    }

    public static function getConfigurationData()
    {
        $data =  self::getContainer()->getParameter('configuration_data');
        if(empty($data)){
            $data = array('configs' => array());
        }
        return $data;
    }

    public static function rebuildContainer($env = "prod")
    {
        $filesystem   = self::getContainer()->get('filesystem');
        $realCacheDir = self::getContainer()->getParameter('kernel.cache_dir');
        self::getContainer()->get('cache_clearer')->clear($realCacheDir);
        $filesystem->remove($realCacheDir);

        exec('php app/console --env="'.self::getContainer()->get('kernel')->getEnvironment().'"');
    }


    protected static function getContainer()
    {
        $kernel = $GLOBALS['kernel'];
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel -> getKernel();
        }
        return $kernel -> getContainer();
    }
}