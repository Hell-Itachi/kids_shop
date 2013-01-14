<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Itc\AdminBundle\Entity\Product\ProductGroup;
use Symfony\Component\Validator\Constraints as Assert;
use Itc\KidsBundle\Entity\Product\KidsProduct;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * KidsProductGroup
 * @Gedmo\Tree(type="closure")
 * @Gedmo\TreeClosure(class="Itc\KidsBundle\Entity\Product\KidsProductGroupClosure")
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProductGroup extends ProductGroup
{   
    /**
     * @Gedmo\TreeParent
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Product\KidsProduct", inversedBy="children")
     * 
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Itc\KidsBundle\Entity\Product\KidsProduct", mappedBy="parent")
     **/
    protected $children;    
    /**
     * @ORM\ManyToMany(
     *     targetEntity="Itc\KidsBundle\Entity\Product\KidsProduct",
     *     mappedBy="productgroup"
     * )
     */
    protected $products;
    
      
    
}
