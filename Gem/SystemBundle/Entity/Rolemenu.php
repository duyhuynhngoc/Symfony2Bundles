<?php

namespace Gem\SystemBundle\Entity;

/**
 * Rolemenu
 */
class Rolemenu extends BaseEntity
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
    private $isdeleted;

    /**
     * @var \Gem\SystemBundle\Entity\Menus
     */
    private $menuid;

    /**
     * @var \Gem\SystemBundle\Entity\Roles
     */
    private $roleid;

    /**
     * @var \Gem\SystemBundle\Entity\Users
     */
    private $modifiedby;


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
     * @return Rolemenu
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
     * @return Rolemenu
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
     * Set menuid
     *
     * @param \Gem\SystemBundle\Entity\Menus $menuid
     *
     * @return Rolemenu
     */
    public function setMenuid(\Gem\SystemBundle\Entity\Menus $menuid = null)
    {
        $this->menuid = $menuid;

        return $this;
    }

    /**
     * Get menuid
     *
     * @return \Gem\SystemBundle\Entity\Menus
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * Set roleid
     *
     * @param \Gem\SystemBundle\Entity\Roles $roleid
     *
     * @return Rolemenu
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

    /**
     * Set modifiedby
     *
     * @param \Gem\SystemBundle\Entity\Users $modifiedby
     *
     * @return Rolemenu
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
}

