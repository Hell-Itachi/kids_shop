<?php

namespace Itc\KidsBundle\Entity\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttrValue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AttrValue
{
    const DEFAULT_VALUE = 0;

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
     * @ORM\Column(name="value", type="string", length=150)
     */
    private $value;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $is_default;
    
    /**
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Template\Attr", inversedBy="attrvalues")
     * @ORM\JoinColumn(name="attr_id", referencedColumnName="id",
     * onDelete="CASCADE")
     */
    protected $attr;

    /**
     * @ORM\OneToMany (
     * targetEntity="Itc\KidsBundle\Entity\Template\KidsProductAttrvalue",
     * mappedBy="attrvalue",
     * cascade={"persist"}
     * )
     */
    private $productattrvalues;
    

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
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return AttrValue
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
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
    /**
     * 
     * @return type
     */
    public function getIsDefault() {
        return $this->is_default;
    }
    /**
     * 
     * @param type $is_default
     */
    public function setIsDefault($is_default) {
        $this->is_default = $is_default;
    }


    /**
     * Set attr
     *
     * @param \Itc\KidsBundle\Entity\Template\Attr $attr
     * @return AttrValue
     */
    public function setAttr(\Itc\KidsBundle\Entity\Template\Attr $attr = null)
    {
        $this->attr = $attr;
    
        return $this;
    }

    /**
     * Get attr
     *
     * @return \Itc\KidsBundle\Entity\Template\Attr 
     */
    public function getAttr()
    {
        return $this->attr;
    }
    
    function __toString(){
        return is_null( $this->value ) ? "" : $this->value ;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add products
     *
     * @param \Itc\KidsBundle\Entity\Product\KidsProduct $products
     * @return AttrValue
     */
    public function addProduct(\Itc\KidsBundle\Entity\Product\KidsProduct $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Itc\KidsBundle\Entity\Product\KidsProduct $products
     */
    public function removeProduct(\Itc\KidsBundle\Entity\Product\KidsProduct $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}