<?php

namespace Itc\KidsBundle\Form\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttrValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden',array('required'=>NULL))
            ->add('value', NULL, array('label'=> ' '))
            ->add('is_default', NULL, array('required'=>NULL))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Template\AttrValue'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_template_attrvaluetype';
    }
}
