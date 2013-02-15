<?php

namespace Itc\KidsBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Itc\AdminBundle\Entity\Product\Product;
/** 
 * 
 * @ORM\DiscriminatorMap
 * (
 *  {
 *       "kids"  = "Itc\KidsBundle\Entity\Product\KidsProduct"
 *  }
 * )
 */
class ProductChild extends Product {
    //put your code here
}

?>
