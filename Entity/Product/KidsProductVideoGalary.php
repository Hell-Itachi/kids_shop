<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidsProductVideoGalary
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProductVideoGalary
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
     *  @ORM\Column(name="product_id", type="integer")
     * @var int 
     */
    private $productId;
    /**
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id",
     * onDelete="CASCADE")
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Product\KidsProduct", inversedBy="videogallery")
     */
    private $product;
    /**
     * @ORM\OneToMany(
     *     targetEntity="Itc\KidsBundle\Entity\Product\KidsProductVideos",
     *     mappedBy="videogallery",
     *     cascade={"persist"}
     * )
     */
    private $video;
    public function __construct()
    {
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return KidsProductVideoGalary
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
    
    public function  getVideo()
    {
        return $this->video;
    }
    
    public function addVideo($video)
    {
        $this->video[] = $video;
        return $this;
    }
    
    public function setProduct($product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return string 
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * Set productId
     *
     * @param string $productId
     * @return Gallery
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    
        return $this;
    }

    /**
     * Get productId
     *
     * @return string 
     */
    public function getProductId()
    {
        return $this->productId;
    }
   public  function __toString()
    {
        return $this->name === null? "": $this->name;
    }
}
