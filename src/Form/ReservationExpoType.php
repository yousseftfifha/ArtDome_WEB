<?php

namespace App\Form;

use App\Entity\Exposition;
use App\Entity\ReservationExpo;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservationExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlace')
            ->add('codeClient', EntityType::class,['class'=>User::class,'choice_label'=>'nom'])
            ->add('codeExpo', EntityType::class,['class'=>Exposition::class,'choice_label'=>'nomExpo'])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationExpo::class,
        ]);
    }
}
