<?php

namespace Gem\TestBundle\Tests\Controller;
use Gem\SystemBundle\Config\Entities;
use Gem\SystemBundle\Lib\EntityManager;
use Symfony\Component\HttpFoundation\Response;


class EntityManagerTest extends BaseController
{
    public function testFindbyId()
    {
        $row = EntityManager::getBy('users', array('roleid' => 2));
        echo $row == null;
    }
}
