<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 11/5/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Entity;



use Gem\SystemBundle\Lib\EntityManager;
use Gem\SystemBundle\Lib\Utils;

class BaseEntity {
    protected $currentData = null;
    private $mappings = array();

    public function __construct()
    {
        $em = EntityManager::getEntityManager();
        $this->mappings = $em->getClassMetadata(get_called_class())->fieldMappings;
    }

    public function loadResourceData()
    {
        if ($this->getId() == null)
            return null;

        $cls = get_called_class();

        $em = EntityManager::getEntityManager();

        $rec = $em->createQueryBuilder($cls)
                ->field('id')->equals($this->getId())->hydrate(false)
                ->getQuery()->getSingleResult();
        var_dump($rec); exit;

        if($rec != null){
            $this->currentData = $rec->toAssocArray();
        }
    }

    public function hasChangeData()
    {
        if ($this->currentData == null){
            $this->loadResourceData();
            var_dump( $this->currentData); exit;
        }

        $data = $this->toAssocArray();
        //var_dump($this->currentData); exit;

        return ($this->currentData === $data);
    }

    public function setData($data){

        if(isset($data['id'])){
            if($this->getId() != null && $data['id'] != $this->getId())
                return;
        }

        foreach($data as $key=>$value)
        {
            $method = "set".ucfirst($key);
            if(method_exists($this, $method))
                $this->{$method}($value);
        }
    }

    public function selfDestroy()
    {
        try {
            Utils::startTransaction();
            if($this->getId() != null) {
                $cls = get_called_class();

                $em = EntityManager::getEntityManager();

                $rec = $em->find($cls, $this->getId());

                if ($rec != null) {
                    $em->remove($rec);
                    $em->flush();
                }
            }
            Utils::commitTransaction();
        }catch (\Exception $e){
            Utils::rollbackTransaction();
            throw new \Exception($e->getMessage());
        }
    }

    public function selfUpdate()
    {
        try {
            Utils::startTransaction();var_dump($this->hasChangeData() == true); exit;
            if ($this->getId() != null && $this->hasChangeData() == true) {

                $this->setLastmodified(Utils::originDatetimeFormat(new \DateTime()));

                $em = EntityManager::getEntityManager();
                $em->persist($this);
                $em->flush();
            }
            Utils::commitTransaction();
        }catch (\Exception $e){
            Utils::rollbackTransaction();
            throw new \Exception($e->getMessage());
        }

    }

    public function toAssocArray($arrAttributes = array())
    {
        if(empty($this->mappings)) {
            $em = EntityManager::getEntityManager();
            $this->mappings = $em->getClassMetadata(get_called_class())->fieldMappings;
        }

        $data = array();
        $properties = $this->mappings;
        $attr = count($arrAttributes) > 0;

        foreach ($properties as $key => $value) {
            if(($attr && !in_array($key, $arrAttributes)))
                continue;
            $m = "get".ucfirst($key);
            if(method_exists($this, $m)) {
                $data[$key] = $this->{$m}();

            }

        }
        return $data;
    }



}