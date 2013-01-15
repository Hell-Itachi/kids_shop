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
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProductGroup extends ProductGroup
{   
    /**
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     * @ORM\ManyToOne(targetEntity="Itc\KidsBundle\Entity\Product\KidsProductGroup", inversedBy="children")
     * 
     */
    protected $parent;
    /**
     * @ORM\OneToMany(targetEntity="Itc\KidsBundle\Entity\Product\KidsProductGroup", mappedBy="parent")
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
