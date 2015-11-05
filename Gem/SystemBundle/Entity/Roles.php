<?php

namespace Gem\SystemBundle\Entity;

/**
 * Roles
 */
class Roles extends BaseEntity
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
    private $level = '0';

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
     * @var \Gem\SystemBundle\Entity\Roles
     */
    private $parent;


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
     * @return Roles
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
     * Set level
     *
     * @param integer $level
     *
     * @return Roles
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     *
     * @return Roles
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
     * @return Roles
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
     * @return Roles
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
     * Set parent
     *
     * @param \Gem\SystemBundle\Entity\Roles $parent
     *
     * @return Roles
     */
    public function setParent(\Gem\SystemBundle\Entity\Roles $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Gem\SystemBundle\Entity\Roles
     */
    public function getParent()
    {
        return $this->parent;
    }
}

