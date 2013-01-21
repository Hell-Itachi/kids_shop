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
     * @ORM\Column(name="value", type="string", length=150)
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

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
}
