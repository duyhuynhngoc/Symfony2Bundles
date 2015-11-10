<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 11/10/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Lib;


use Doctrine\DBAL\Connection;
use Gem\SystemBundle\Config\SystemConfig;

class Utils {

    /**
     * Start a SERIALIZABLE transaction
     * @return none
     */
    public static function startTransaction()
    {
        $entityManager = EntityManager::getEntityManager();
        if($entityManager != NULL)
        {
            $conn = $entityManager->getConnection();
            //set Isolation level to Serializabe
            $conn->setTransactionIsolation(Connection::TRANSACTION_SERIALIZABLE);
            $conn->beginTransaction();
        }
    }

    /**
     * Commit current transaction
     * @return none
     */
    public static function commitTransaction()
    {
        $entityManager = EntityManager::getEntityManager();
        if($entityManager != NULL)
        {
            $conn = $entityManager->getConnection();
            $conn->commit();
        }
    }

    /**
     * Rollback current transaction
     * @return none
     */
    public static function rollbackTransaction()
    {
        $entityManager = EntityManager::getEntityManager();
        if($entityManager != NULL)
        {
            $conn = $entityManager->getConnection();
            if ($conn->isTransactionActive()){
                $conn->rollback();
            }
        }
    }

    public static function originDatetimeFormat($datetime)
    {
        $timeZone = new \DateTimeZone("UTC");
        if(is_string($datetime)){
            return \DateTime::createFromFormat(SystemConfig::$date_time_format, $datetime, $timeZone);
        }elseif (is_int($datetime)){
            $date = new \DateTime("now", $timeZone);
            $date->setTimestamp($datetime);
            return $date;
        }
        return null;
    }

}