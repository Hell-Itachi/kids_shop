<?php

namespace Itc\KidsBundle\Form\Banner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $disable = array( 'disabled'=>'disabled' );
        $builder
            ->add('tag')
            ->add('description')
            ->add('kod', null, $disable )
            ->add('width')
            ->add('height')
            ->add('is_used', null, array('required'=>NULL))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Banner\Banner'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_banner_bannertype';
    }
}
