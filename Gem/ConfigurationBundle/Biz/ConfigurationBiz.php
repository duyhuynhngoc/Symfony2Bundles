<?php
/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 10/16/2015
 * Modified by: Duy Huynh
 */

namespace Gem\ConfigurationBundle\Biz;


use Gem\ConfigurationBundle\Lib\Configuration;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class ConfigurationBiz {

    public static function saveConfig($data)
    {
        $dataSource = Configuration::getConfigurationData();

        $path = __DIR__."/../Resource/config/system.yml";

        if(!is_file($path)){
            throw new \Exception("File system.yml does not exists.");
        }

        $configData = self::apply($dataSource['configs'], $data);

        $dataSource['configs'] = $configData;

        $yaml = Yaml::dump(array("gem_configuration"=>$dataSource), 10);
        file_put_contents($path, $yaml);

        Configuration::rebuildContainer();

    }

    /**
     * @param $source
     * @param $data
     * @return mixed
     */
    private static function apply($source, $data)
    {
        foreach($data as $key=>$value){
            if(isset($source[$key])) {
                if (!is_array($value) && !is_array($source[$key])) {
                    $source[$key] = $value;
                } else {
                    if (count($value) > 0) {
                        $rs = self::apply($source[$key], $value);
                        $source[$key] = $rs;
                    }
                }
            }
        }
        return $source;
    }


    public static function buildConfiguration($keyList = array())
    {
        $finder = new Finder();
        $finder->files()->name('*.php')->in(__DIR__."/../Roles")->sortByName();

        $results = array(
            "title" => "Configuration",
            "type" => "object",
            "properties" => array()
        );

        foreach ($finder as $file) {
            $filename = str_replace('.php', '', $file->getRelativePathname());

            if ($filename == "RoleBase")
                continue;

            $class = 'Ccicore\\ConfigurationBundle\\Roles\\' . $filename;

            $cls = new $class();

            if (count($keyList) > 0 && !in_array($cls->getRootName(), $keyList)) {
                continue;
            }

            $data = $cls->buildConstructure();

            if (count($data['properties']) > 0) {
                $results['properties'][$cls->getRootName()] = $data;
            }
        }

        return $results;
    }

}