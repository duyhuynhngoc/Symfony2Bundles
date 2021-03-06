<?php
/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 11/9/2015
 * Modified by: Duy Huynh
 */

namespace Gem\TestBundle\Command;


use Gem\SystemBundle\Biz\SystemBiz;
use Gem\SystemBundle\Lib\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SystemCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this->setName("system:test", "");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        SystemBiz::saveModule(array('isdisabled'=>true, 'id'=>5));
    }
}