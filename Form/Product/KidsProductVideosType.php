<?php

namespace Itc\KidsBundle\Form\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KidsProductVideosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kod')
            ->add('content',NULL , array('attr' => array('class' => 'tinymce', 'data-theme' => 'medium' )))
            ->add('is_visible', NULL, array('required'=>NULL))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Product\KidsProductVideos'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_product_kidsproductvideostype';
    }
}
