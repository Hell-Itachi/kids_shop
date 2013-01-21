<?php

namespace Itc\KidsBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttrType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AttrType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany (
     * targetEntity="Itc\KidsBundle\Entity\Template\Attr",
     * mappedBy="attrtype",
     * cascade={"persist"}
     * )
     */
    private $attributes;
    
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
     * @return AttrType
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
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add attributes
     *
     * @param \Itc\KidsBundle\Entity\Template\Attr $attributes
     * @return AttrType
     */
    public function addAttribute(\Itc\KidsBundle\Entity\Template\Attr $attributes)
    {
        $this->attributes[] = $attributes;
    
        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Itc\KidsBundle\Entity\Template\Attr $attributes
     */
    public function removeAttribute(\Itc\KidsBundle\Entity\Template\Attr $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    function __toString(){
        return is_null( $this->name ) ? "" : $this->name ;
    }
}