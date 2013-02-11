<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidsProductVideos
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProductVideos
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
     * @var integer
     *
     * @ORM\Column(name="kod", type="integer")
     */
    private $kod;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean")
     */
    private $is_visible;
   /**
     * 
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id",
     * onDelete="CASCADE")
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Product\KidsProductVideoGalary", inversedBy="videogallery")
     * 
     */
    private $videogallery;
    public function setVideoGallery(\Itc\KidsBundle\Entity\Product\KidsProductVideoGalary
                                                            $gallery = null)
    {
        $this->videogallery = $gallery;
    
        return $this;
    }
    public function getVideoGallery()
    {
        return $this->videogallery;
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
     * Set kod
     *
     * @param integer $kod
     * @return KidsProductVideos
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
     * Set content
     *
     * @param string $content
     * @return KidsProductVideos
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set is_visible
     *
     * @param boolean $isVisible
     * @return KidsProductVideos
     */
    public function setIsVisible($isVisible)
    {
        $this->is_visible = $isVisible;
    
        return $this;
    }

    /**
     * Get is_visible
     *
     * @return boolean 
     */
    public function getIsVisible()
    {
        return $this->is_visible;
    }

}
