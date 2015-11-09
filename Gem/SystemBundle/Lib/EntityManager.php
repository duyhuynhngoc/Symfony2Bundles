<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 11/5/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Lib;


use Gem\SystemBundle\Config\Entities;

class EntityManager {


    public static function getById($entityAlias, $id, $includeDeleted = false)
    {
        $cls = Entities::getEntityPath($entityAlias);
        $em = self::getEntityManager();

        $rec = $em->find($cls, $id);
        if ($rec != null) {
            if (!$includeDeleted && $rec->getIsdeleted()) {
                return null;
            }
            return $rec;
        }
        return null;
    }

    public static function getBy($entityAlias, $params = array(), $sorts = array())
    {
        $cls = Entities::getEntityPath($entityAlias);

        $em = self::getEntityManager();

        $emFind = $em->getRepository($cls);

        return $emFind->findBy($params, $sorts);
    }

    public static function getAllEntity($entityAlias, $includeDeleted = false)
    {
        $cls = Entities::getEntityPath($entityAlias);

        $em = self::getEntityManager();

        $datasql = $em->createQueryBuilder();    //create query builder
        $datasql->select('t')
            ->from($cls, 't');
        if (!$includeDeleted) {
            $datasql->andWhere($datasql->expr()->eq('t.isdeleted', '?1'));
            $datasql->setParameter(1, 0);
        }

        return $datasql->getQuery() -> getResult();
    }



    public static function pagingResult($entityAlias, $searchParams = array(), array $arrAttributes = array())
    {
        $cls = Entities::getEntityPath($entityAlias);

        $em = self::getEntityManager();

        $datasql = $em->createQueryBuilder();    //create query builder
        $datasql->select('t')
            ->from($cls, 't');

        $search = isset($searchParams['search'])?$searchParams['search']:array();
        $data = array();
        $limit = 0;
        if(isset($searchParams['limit']) && $searchParams['limit'] > 0){
            $limit = $searchParams['limit'];
            $datasql->setMaxResults($limit);
        }

        if(isset($searchParams['start']) && $limit > 0){
            $total = self::count($entityAlias, $search);
            if($total <= 0)
                return $data;
            $start = $searchParams['start'];
            if($start < 0)
                $start = 0;
            else if($start > $total){
                $start = (round($total / $start, 0) - 1) * $limit;
            }
            $datasql->setFirstResult($start);
        }

        $order = 1;

        foreach($search as $key=>$value){
            $datasql->andWhere($datasql->expr()->eq('t.'.$key, '?'.$order));
            $datasql->setParameter($order, $value);
            $order++;
        }

        $result = $datasql->getQuery()->getResult();

        foreach($result as $entity) {
            $data[] = $entity->toAssocArray($arrAttributes);
        }

        return $data;
    }

    public static function distinct($entityAlias, $attributes = array(), $searchParams = array())
    {

    }

    public static function count($entityAlias, $searchParams = array())
    {
        $cls = Entities::getEntityPath($entityAlias);

        $em = self::getEntityManager();

        $datasql = $em->createQueryBuilder();    //create query builder
        $datasql->select('COUNT(t.id)')
            ->from($cls, 't');

        $order = 1;
        foreach($searchParams as $key=>$value){
            $datasql->andWhere($datasql->expr()->eq('t.'.$key, '?'.$order));
            $datasql->setParameter($order, $value);
            $order++;
        }

        return $datasql->getQuery()->getSingleScalarResult();
    }

    private static function joinTable($entityLeftAlias, $entityRightAlias)
    {

    }

    public static function getEntityManager()
    {
        return self::getContainer()->get('doctrine.orm.entity_manager');
    }

    private static function getContainer()
    {
        $kernel = $GLOBALS['kernel'];
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel -> getKernel();
        }
        return $kernel -> getContainer();
    }
}