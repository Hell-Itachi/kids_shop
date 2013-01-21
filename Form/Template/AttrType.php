<?php

namespace Itc\KidsBundle\Form\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttrType extends AbstractType
{
     public function __construct($option){
        $this->option=$option;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('attrtype');
                if($options['attr']['new']){
           $builder ->add('attrvalues', 'collection', array('type' => new AttrValueType($options['attr']['class'])));}
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Template\Attr'
        ));
    }

    public function getName()
    {
          if($this->option=='select')
        {
            $attr_id="appendedDropdownButton";
        }
        else{
            $attr_id='itc_kidsbundle_template_attrtype';
        }
        return $attr_id;
    }
}
