<?php

namespace Itc\KidsBundle\Entity\Shipping;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use \Itc\AdminBundle\Entity\Content;


/**
 * ShippingMethod
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class ShippingMethod extends Content
{
    protected $metaTitle;
    protected $metaDescription;
    protected $metaKeyword;
    protected $description;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    protected $price;


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
     * Set price
     *
     * @param float $price
     * @return ShippingMethod
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }
         
   public function setIconImage($image)
    {
        $this->iconImage = $image;
    }
    
    public function getIconImage()
    {
        return $this->iconImage;
    }
}
