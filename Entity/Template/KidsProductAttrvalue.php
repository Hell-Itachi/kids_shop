<?php

namespace Itc\KidsBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidsProductAttrvalue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProductAttrvalue
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
     * @ORM\Column(name="value", type="string", length=150, nullable=true)
     */
    private $value;


    /**
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Template\AttrValue", inversedBy="productattrvalues")
     * @ORM\JoinColumn(name="attr_id", referencedColumnName="id",
     * onDelete="CASCADE")
     */
    protected $attrvalue;

    /**
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Product\KidsProduct", inversedBy="productattrvalues")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $product;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean")
     */
    private $is_visible;
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
     * Set value
     *
     * @param string $value
     * @return KidsProductAttrvalue
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }
    
    function __construct() {
        $this->attrvalue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }
   /**
     * 
     * @return type
     */
    public function getIsVisible() {
        return $this->is_visible;
    }
    /**
     * 
     * @param type $is_visible
     */
    public function setIsVisible($is_visible) {
        $this->is_visible = $is_visible;
    }
    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    public function getAttrvalue() {
        return $this->attrvalue;
    }

    public function setAttrvalue($attrvalue) {
        $this->attrvalue = $attrvalue;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
    }
   /**
     * Add product
     *
     * @param \Itc\KidsBundle\Entity\Product\KidsProduct $product
     * @return Template
     */
    public function addProduct(\Itc\KidsBundle\Entity\Product\KidsProduct $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Itc\KidsBundle\Entity\Product\KidsProduct $product
     */
    public function removeProduct(\Itc\KidsBundle\Entity\Product\KidsProduct $product)
    {
        $this->product->removeElement($product);
    }
 /**
     * Add attrvalue
     *
     * @param \Itc\KidsBundle\Entity\Template\AttrValue $attrvalue
     * @return Template
     */
    public function addAttrvalue(\Itc\KidsBundle\Entity\Template\AttrValue $attrvalue)
    {
        $this->attrvalue[] = $attrvalue;
    
        return $this;
    }

    /**
     * Remove attrvalue
     *
     * @param \Itc\KidsBundle\Entity\Template\AttrValue $attrvalue
     */
    public function removeAttribute(\Itc\KidsBundle\Entity\Template\Attr $attrvalue)
    {
        $this->attrvalue->removeElement($attrvalue);
    }
}
