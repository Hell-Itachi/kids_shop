<?php

namespace Itc\KidsBundle\Form\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateListType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
           $builder ->add('name', 'choice', array('choices'=> $options['data']));
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_templatelist';
    }
}
