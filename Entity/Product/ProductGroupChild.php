<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Itc\AdminBundle\Entity\Product\ProductGroup;
/** 
 * 
 * @ORM\DiscriminatorMap
 * (
 *  {
 *       "kids"  = "Itc\KidsBundle\Entity\Product\KidsProductGroup"
 *  }
 * )
 */
class ProductGroupChild extends ProductGroup{
    //put your code here
}

?>
