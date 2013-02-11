<?php

namespace Itc\KidsBundle\Form\Banner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerImgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $disable = array( 'disabled'=>'disabled' );
        $builder
            ->add('image', 'file', array('required'=>NULL))
            ->add('alt')
            //->add('kod', null, $disable )
            ->add('visible', null, array('required'=>NULL))
            //->add('banner', null, $disable )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Banner\BannerImg'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_banner_bannerimgtype';
    }
}
