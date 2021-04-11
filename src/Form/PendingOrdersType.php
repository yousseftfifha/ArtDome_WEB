<?php

namespace App\Form;

use App\Entity\PendingOrders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PendingOrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderid')
            ->add('innonumber')
            ->add('quantity')
            ->add('status')
            ->add('oeuvreid')
            ->add('iduser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PendingOrders::class,
        ]);
    }
}
