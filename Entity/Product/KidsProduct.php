<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Itc\KidsBundle\Entity\Product\ProductChild;
use Symfony\Component\Validator\Constraints as Assert;
use Itc\KidsBundle\Entity\Product\KidsProductGroup;
use Itc\KidsBundle\Entity\Product\KidsProductProxy;
use Itc\KidsBundle\Entity\Product\KidsProductTranslation;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * KidsProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class KidsProduct extends ProductChild
{

    /**
     * @ORM\ManyToMany(targetEntity="Itc\KidsBundle\Entity\Product\KidsProductGroup", inversedBy="products")
     * @ORM\JoinTable(name="product_groups")
     */    
    protected $productgroups;


    /**
     * @ORM\OneToMany (
     * targetEntity="Itc\KidsBundle\Entity\Template\KidsProductAttrvalue",
     * mappedBy="product",
     * cascade={"persist", "remove"}
     * )
     */
    private $productattrvalues;
    /**
     * @ORM\OneToMany(
     *     targetEntity="Itc\KidsBundle\Entity\Product\KidsProductVideoGalary",
     *     mappedBy="product",
     *     cascade={"persist"}
     * )
     */
    protected $videogalleries;
    public function addProductGroups($productgroups) {
        $this->productgroups[] = $productgroups;
    }
    /**
     * Remove menus
     *
     * @param Itc\KidsBundle\Entity\Product\KidsProductGroup $productgroups
     */
    
    public function removeProductGroups(\Itc\KidsBundle\Entity\Product\KidsProductGroup $productgroups)
    {
        $this->productgroups->removeElement($productgroups);
    }
    
    public function getProductGroups() {
        return $this->productgroups;
    }

    public function addAttrvalues($attrvalues) {
        $this->productattrvalues[] = $attrvalues;
    }
    /**
     * Remove menus
     *
     * @param Itc\KidsBundle\Entity\Template\AttrValue $attrvalues
     */
    
    public function removeAttrvalues(\Itc\KidsBundle\Entity\Template\AttrValue $attrvalues)
    {
        $this->productattrvalues->removeElement($attrvalues);
    }
    
    public function getAttrvalues() {
        return $this->productattrvalues;
    }
    public function  setVideoGalleries($videogallery)
    {
        $this->videogalleries[] = $videogallery;
    }
    public function  getVideoGalleries()
    {
        return $this->videogalleries;
    }  
    function __construct() {
        parent::__construct();
        $this->productgroups = new ArrayCollection();
        $this->attrvalues = new ArrayCollection();
        $this->videogalleries = new ArrayCollection();
    }
}
