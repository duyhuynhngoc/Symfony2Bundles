<?php

namespace Gem\SystemBundle\Entity;

/**
 * Rolemodule
 */
class Rolemodule extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $lastmodified;

    /**
     * @var integer
     */
    private $isdeleted = '0';

    /**
     * @var \Gem\SystemBundle\Entity\Users
     */
    private $modifiedby;

    /**
     * @var \Gem\SystemBundle\Entity\Modules
     */
    private $moduleid;

    /**
     * @var \Gem\SystemBundle\Entity\Roles
     */
    private $roleid;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     *
     * @return Rolemodule
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;

        return $this;
    }

    /**
     * Get lastmodified
     *
     * @return \DateTime
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Set isdeleted
     *
     * @param integer $isdeleted
     *
     * @return Rolemodule
     */
    public function setIsdeleted($isdeleted)
    {
        $this->isdeleted = $isdeleted;

        return $this;
    }

    /**
     * Get isdeleted
     *
     * @return integer
     */
    public function getIsdeleted()
    {
        return $this->isdeleted;
    }

    /**
     * Set modifiedby
     *
     * @param \Gem\SystemBundle\Entity\Users $modifiedby
     *
     * @return Rolemodule
     */
    public function setModifiedby(\Gem\SystemBundle\Entity\Users $modifiedby = null)
    {
        $this->modifiedby = $modifiedby;

        return $this;
    }

    /**
     * Get modifiedby
     *
     * @return \Gem\SystemBundle\Entity\Users
     */
    public function getModifiedby()
    {
        return $this->modifiedby;
    }

    /**
     * Set moduleid
     *
     * @param \Gem\SystemBundle\Entity\Modules $moduleid
     *
     * @return Rolemodule
     */
    public function setModuleid(\Gem\SystemBundle\Entity\Modules $moduleid = null)
    {
        $this->moduleid = $moduleid;

        return $this;
    }

    /**
     * Get moduleid
     *
     * @return \Gem\SystemBundle\Entity\Modules
     */
    public function getModuleid()
    {
        return $this->moduleid;
    }

    /**
     * Set roleid
     *
     * @param \Gem\SystemBundle\Entity\Roles $roleid
     *
     * @return Rolemodule
     */
    public function setRoleid(\Gem\SystemBundle\Entity\Roles $roleid = null)
    {
        $this->roleid = $roleid;

        return $this;
    }

    /**
     * Get roleid
     *
     * @return \Gem\SystemBundle\Entity\Roles
     */
    public function getRoleid()
    {
        return $this->roleid;
    }
}

