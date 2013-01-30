<?php

namespace Itc\KidsBundle\Form\Shipping;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Itc\KidsBundle\Entity\Shipping\ShippingMethod;

class ShippingMethodImageType extends AbstractType 
{
    public function getName() {
        return 'itc_kidsbundle_shippingimagetype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('iconImage', 'file', 
                        array('label' => 'icon',
                                'data_class' => 
                                    'Symfony\Component\HttpFoundation\File\File'
                        )
                    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Shipping\ShippingMethod'
        ));
    }

}

?>
