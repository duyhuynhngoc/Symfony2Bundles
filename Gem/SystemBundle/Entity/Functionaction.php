<?php

namespace Gem\SystemBundle\Entity;

/**
 * Functionaction
 */
class Functionaction extends BaseEntity
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
     * @var \Gem\SystemBundle\Entity\Actions
     */
    private $actionid;

    /**
     * @var \Gem\SystemBundle\Entity\Functions
     */
    private $functionid;


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
     * @return Functionaction
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
     * @return Functionaction
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
     * @return Functionaction
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
     * Set actionid
     *
     * @param \Gem\SystemBundle\Entity\Actions $actionid
     *
     * @return Functionaction
     */
    public function setActionid(\Gem\SystemBundle\Entity\Actions $actionid = null)
    {
        $this->actionid = $actionid;

        return $this;
    }

    /**
     * Get actionid
     *
     * @return \Gem\SystemBundle\Entity\Actions
     */
    public function getActionid()
    {
        return $this->actionid;
    }

    /**
     * Set functionid
     *
     * @param \Gem\SystemBundle\Entity\Functions $functionid
     *
     * @return Functionaction
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
}

