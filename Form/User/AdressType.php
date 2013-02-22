<?php

namespace Itc\KidsBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userid')
            ->add('fio')
            ->add('h_num')
            ->add('street')
            ->add('city')
            ->add('postcode')
            ->add('state')
            ->add('pd_id')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\User\Adress'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_user_adresstype';
    }
}
