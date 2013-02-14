<?php

namespace Itc\KidsBundle\Entity\Banner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Itc\KidsBundle\Entity\Banner\Banner;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Itc\AdminBundle\ItcAdminBundle;
/**
 * BannerImg
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class BannerImg
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="menu_icon", fileNameProperty="url")
     *
     * @var File $image
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var integer
     *
     * @ORM\Column(name="kod", type="integer")
     */
    private $kod;

    /**
     * @var boolean $visible
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    protected $visible;
    /**
     * @var integer
     *
     * @ORM\Column(name="banner_id", type="integer")
     */
    protected $banner_id;
    /**
     * @ORM\ManyToOne(targetEntity="Banner", inversedBy="img")
     * @ORM\JoinColumn(name="banner_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $banner; 
    
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
     * Set url
     *
     * @param string $url
     * @return BannerImg
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
     * Set image
     *
     * @param string $image
     * @return BannerImg
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return BannerImg
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set kod
     *
     * @param integer $kod
     * @return BannerImg
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
     * Set visible
     *
     * @param boolean $visible
     * @return MenuSys
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
    
    public function getBanner() {
        return $this->banner;
    }

    public function setBanner(Banner $banner) {
        $this->banner = $banner;
    }

    public function getBannerId() {
        return $this->banner_id;
    }
  /**
     * @ORM\PostPersist
     */
    public function thumbImage()
    {
        $imagine = new Imagine();
        $mode    = ImageInterface::THUMBNAIL_OUTBOUND;
        $size    = new Box($this->banner->getWidth(), $this->banner->getHeight());
        
        $container = ItcAdminBundle::getContainer();
        $helper = 
            $container->get('vich_uploader.templating.helper.uploader_helper');
        $rootDir =  $container->get('kernel')->getRootDir();
        $pathToImage = $rootDir. "/../web".$helper->asset($this, 'image');
        $image = $imagine->open($pathToImage);
        $image->thumbnail($size, $mode)
                  ->save($pathToImage);
    }

}
