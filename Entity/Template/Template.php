<?php

namespace Itc\KidsBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * Template
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Template
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
     * @ORM\OneToMany (
     * targetEntity="Itc\KidsBundle\Entity\Template\Attr",
     * mappedBy="templ",
     * cascade={"persist"}
     * )
     */
    private $attributes;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100)
     */
    private $url;

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
     * @return Template
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
     * Set url
     *
     * @param string $url
     * @return Template
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return Template
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
}