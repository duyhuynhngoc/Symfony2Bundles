<?php

namespace Gem\SystemBundle\Entity;

/**
 * Modulefunction
 */
class Modulefunction extends BaseEntity
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
     * @var \Gem\SystemBundle\Entity\Functions
     */
    private $functionid;

    /**
     * @var \Gem\SystemBundle\Entity\Modules
     */
    private $moduleid;

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
     * @return Modulefunction
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
     * @return Modulefunction
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
     * Set functionid
     *
     * @param \Gem\SystemBundle\Entity\Functions $functionid
     *
     * @return Modulefunction
     */
    public function setFunctionid(\Gem\SystemBundle\Entity\Functions $functionid = null)
    {
        $this->functionid = $functionid;

        return $this;
    }

    /**
     * Get functionid
     *
     * @return \Gem\SystemBundle\Entity\Functions
     */
    public function getFunctionid()
    {
        return $this->functionid;
    }

    /**
     * Set moduleid
     *
     * @param \Gem\SystemBundle\Entity\Modules $moduleid
     *
     * @return Modulefunction
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
     * Set modifiedby
     *
     * @param \Gem\SystemBundle\Entity\Users $modifiedby
     *
     * @return Modulefunction
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

