<?php

namespace Itc\KidsBundle\Form\Shipping;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShippingMethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('title')
            ->add('kod');
        if($options["attr"]["new"]){
            $builder->add( 'iconImage', 'file', array('required'=>NULL) );
        }
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Shipping\ShippingMethod'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_shipping_shippingmethodtype';
    }
}
