<?php

namespace Itc\KidsBundle\Form\Product;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Itc\AdminBundle\Form\Product\ProductType;

/**
 * Description of KidsProductType
 *
 * @author root
 */
class KidsProductType extends ProductType {

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
         
        $builder->add('productGroups', 'entity', 
                    array('class' => 'ItcKidsBundle:Product\KidsProductGroup',
                        'property' => 'title',
                        'multiple' => 'checkboxes',
                        'expanded' => 'checkboxes'))
                ->add('productGroup', null, array('required'=>NULL,"class"=> 'ItcKidsBundle:Product\KidsProductGroup'))
            ;
    }
}