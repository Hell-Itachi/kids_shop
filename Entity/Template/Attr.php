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
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Template\AttrType", inversedBy="attributes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $attrtype;

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
     * @ORM\OneToMany (
     * targetEntity="Itc\KidsBundle\Entity\Template\AttrValue",
     * mappedBy="attr",
     * cascade={"persist"}
     * )
     */
    private $attrvalues;
    /**
     * @var integer
     *
     * @ORM\Column(name="kod", type="integer" , nullable=true)
     */
    private $kod;
    public function getKod() {
        return $this->kod;
    }

    public function setKod($kod) {
        $this->kod = $kod;
    }

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attrvalues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add attrvalues
     *
     * @param \Itc\KidsBundle\Entity\Template\AttrValue $attrvalues
     * @return Attr
     */
    public function addAttrvalue(\Itc\KidsBundle\Entity\Template\AttrValue $attrvalues)
    {
        $this->attrvalues[] = $attrvalues;
    
        return $this;
    }

    /**
     * Remove attrvalues
     *
     * @param \Itc\KidsBundle\Entity\Template\AttrValue $attrvalues
     */
    public function removeAttrvalue(\Itc\KidsBundle\Entity\Template\AttrValue $attrvalues)
    {
        $this->attrvalues->removeElement($attrvalues);
    }

    /**
     * Get attrvalues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttrvalues()
    {
        return $this->attrvalues;
    }
    
    function __toString(){
        return is_null( $this->name ) ? "" : $this->name ;
    }

    /**
     * Set attrtype
     *
     * @param \Itc\KidsBundle\Entity\Template\AttrType $attrtype
     * @return Attr
     */
    public function setAttrtype(\Itc\KidsBundle\Entity\Template\AttrType $attrtype = null)
    {
        $this->attrtype = $attrtype;
    
        return $this;
    }

    /**
     * Get attrtype
     *
     * @return \Itc\KidsBundle\Entity\Template\AttrType 
     */
    public function getAttrtype()
    {
        return $this->attrtype;
    }
}