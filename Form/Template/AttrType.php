<?php

namespace Itc\KidsBundle\Form\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttrType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name');
                if($options['attr']['new']){
           $builder ->add('attrvalues', 'collection', array('type' => new AttrValueType()));}
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Template\Attr'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_template_attrtype';
    }
}
