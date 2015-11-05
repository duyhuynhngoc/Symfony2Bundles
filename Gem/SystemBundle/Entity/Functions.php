<?php

namespace Gem\SystemBundle\Entity;

/**
 * Functions
 */
class Functions extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $isdeleted = '0';

    /**
     * @var \DateTime
     */
    private $lastmodified;

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
     * Set name
     *
     * @param string $name
     *
     * @return Functions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isdeleted
     *
     * @param integer $isdeleted
     *
     * @return Functions
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
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     *
     * @return Functions
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
     * Set modifiedby
     *
     * @param \Gem\SystemBundle\Entity\Users $modifiedby
     *
     * @return Functions
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

