<?php

namespace Gem\SystemBundle\Entity;

/**
 * Menus
 */
class Menus extends BaseEntity
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
     * @var string
     */
    private $alias;

    /**
     * @var integer
     */
    private $level = '1';

    /**
     * @var string
     */
    private $event;

    /**
     * @var \DateTime
     */
    private $lastmodified;

    /**
     * @var integer
     */
    private $isdeleted = '0';

    /**
     * @var string
     */
    private $view;

    /**
     * @var \Gem\SystemBundle\Entity\Menus
     */
    private $parent;

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
     * @return Menus
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
     * Set alias
     *
     * @param string $alias
     *
     * @return Menus
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Menus
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
     * Set event
     *
     * @param string $event
     *
     * @return Menus
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     *
     * @return Menus
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
     * @return Menus
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
     * Set view
     *
     * @param string $view
     *
     * @return Menus
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set parent
     *
     * @param \Gem\SystemBundle\Entity\Menus $parent
     *
     * @return Menus
     */
    public function setParent(\Gem\SystemBundle\Entity\Menus $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Gem\SystemBundle\Entity\Menus
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set modifiedby
     *
     * @param \Gem\SystemBundle\Entity\Users $modifiedby
     *
     * @return Menus
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

