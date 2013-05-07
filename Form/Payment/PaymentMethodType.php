<?php

namespace Itc\KidsBundle\Form\Payment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentMethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company')
            ->add('acc_num')
            ->add('kod');
         if($options["attr"]["new"]){
            $builder->add( 'iconImage', 'file', array('required'=>NULL) );
        }
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Itc\KidsBundle\Entity\Payment\PaymentMethod'
        ));
    }

    public function getName()
    {
        return 'itc_kidsbundle_payment_paymentmethodtype';
    }
}
