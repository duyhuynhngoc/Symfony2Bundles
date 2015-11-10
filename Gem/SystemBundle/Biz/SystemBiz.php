<?php
/**
 * Code Owner: Duy Huyn
 * Modified date: 11/10/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Biz;


use Gem\SystemBundle\Config\Entities;
use Gem\SystemBundle\Lib\EntityManager;

class SystemBiz {



    public static function saveModule($data)
    {
        $isdeleted = false;
        $isdisabled = false;
        $cls = Entities::getEntityPath("modules");

        if(isset($data['isdeleted']) && is_bool($data['isdeleted'])){
            $isdeleted = $data['isdeleted'];
            unset($data['isdeleted']);
        }

        if(isset($data['isdisabled']) && is_bool($data['isdisabled'])){
            $isdisabled = $data['isdisabled'];
            unset($data['isdisabled']);
        }

        $obj = new $cls($data);

        if($isdeleted && isset($data['id'])){
            $obj = EntityManager::getById("modules", $data['id']);
            $obj->selfDestroy();
        }elseif($isdisabled && isset($data['id'])){
            $obj = EntityManager::getById("modules", $data['id']);
            $obj->setIsdeleted(1);
            $obj->selfUpdate();
        }
    }


    private static function deleteModule($id)
    {

    }
}