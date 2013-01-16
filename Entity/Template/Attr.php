<?php

namespace Itc\KidsBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attr
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Attr
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     */
    private $type;

    /**
     * 
     * @var integer
     *
     * @ORM\Column(name="templ_id", type="integer")
     */
    private $templ_id;
    /**
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Template\Template", inversedBy="attributes")
     * @ORM\JoinColumn(name="templ_id", referencedColumnName="id",
     * onDelete="CASCADE")
     */
    protected $templ;

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
     * @return Attr
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
     * Set type
     *
     * @param string $type
     * @return Attr
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set templ_id
     *
     * @param integer $templId
     * @return Attr
     */
    public function setTemplId($templId)
    {
        $this->templ_id = $templId;
    
        return $this;
    }

    /**
     * Get templ_id
     *
     * @return integer 
     */
    public function getTemplId()
    {
        return $this->templ_id;
    }

    /**
     * Set templ
     *
     * @param \Itc\KidsBundle\Entity\Template\Template $templ
     * @return Attr
     */
    public function setTempl(\Itc\KidsBundle\Entity\Template\Template $templ = null)
    {
        $this->templ = $templ;
    
        return $this;
    }

    /**
     * Get templ
     *
     * @return \Itc\KidsBundle\Entity\Template\Template 
     */
    public function getTempl()
    {
        return $this->templ;
    }
}