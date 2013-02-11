<?php

namespace Itc\KidsBundle\Entity\Banner;

use Doctrine\ORM\Mapping as ORM;
use Itc\KidsBundle\Entity\Banner\BannerImg;

/**
 * Banner
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Banner
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
     * @ORM\Column(name="tag", type="string", length=255)
     */
    private $tag;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="kod", type="integer")
     */
    private $kod;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_used", type="boolean")
     */
    private $is_used;
    
    /**
     * @ORM\OneToMany(targetEntity="BannerImg", mappedBy="banner")
     */
    protected $img;

    public function __construct() {
        $this->img = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tag
     *
     * @param string $tag
     * @return Banner
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

        
    /**
     * Set kod
     *
     * @param integer $kod
     * @return Banner
     */
    public function setKod($kod)
    {
        $this->kod = $kod;
    
        return $this;
    }

    /**
     * Get kod
     *
     * @return integer 
     */
    public function getKod()
    {
        return $this->kod;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Banner
     */
    public function setWidth($width)
    {
        $this->width = $width;
    
        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Banner
     */
    public function setHeight($height)
    {
        $this->height = $height;
    
        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set is_used
     *
     * @param boolean $isUsed
     * @return Banner
     */
    public function setIsUsed($isUsed)
    {
        $this->is_used = $isUsed;
    
        return $this;
    }

    /**
     * Get is_used
     *
     * @return boolean 
     */
    public function getIsUsed()
    {
        return $this->is_used;
    }
    
    public function getImg() {
        return $this->img;
    }

    public function setImg($img) {
        $this->img = $img;
    }
    function __toString(){
        return (string)$this->id;
    }

}
