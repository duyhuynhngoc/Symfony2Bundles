<?php

namespace Gem\ConfigurationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GemConfigurationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('system.yml');

        $globals = $container->getParameter("globals");
        $config_data = $container->getParameter("configuration_configs");

        if (!empty($globals)){
            foreach($globals as $global){
                $globalValue = $this->getGlobalValue($config_data, $global);
                if($globalValue != null){
                    $container->setParameter($global, $globalValue);
                }
            }
        }
    }

    private function getGlobalValue($globals, $name)
    {
        $keys = explode('.', $name);

        foreach($keys as $key){
            if(isset($globals[$key])){
                $globals = $globals[$key];
            }else{
                $globals = null;
                break;
            }
        }

        return $globals;
    }
}
