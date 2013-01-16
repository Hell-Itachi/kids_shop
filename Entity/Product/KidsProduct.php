<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Itc\AdminBundle\Entity\Product\Product;
use Symfony\Component\Validator\Constraints as Assert;
use Itc\KidsBundle\Entity\Product\KidsProductGroup;
use Itc\KidsBundle\Entity\Product\KidsProductProxy;
use Itc\KidsBundle\Entity\Product\KidsProductTranslation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * KidsProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KidsProduct extends Product
{
    /**
     * @ORM\ManyToMany(targetEntity="Itc\KidsBundle\Entity\Product\KidsProductGroup", inversedBy="products")
     * @ORM\JoinTable(name="product_group")
     */    
    protected $productgroup;
}
