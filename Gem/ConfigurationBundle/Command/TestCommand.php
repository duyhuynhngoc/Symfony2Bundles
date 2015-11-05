<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 10/16/2015
 * Modified by: Duy Huynh
 */

namespace Gem\ConfigurationBundle\Command;


use Gem\ConfigurationBundle\DependencyInjection\GemConfigurationExtension;
use Gem\ConfigurationBundle\Lib\Configuration;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TestCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this->setName("gem:test");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}