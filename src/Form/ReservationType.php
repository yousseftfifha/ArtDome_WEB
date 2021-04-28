<?php

namespace App\Form;

use App\Entity\Endroit;
use App\Entity\Reservation;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idclient', EntityType::class,['class'=>User::class,'choice_label'=>'ID'])
            ->add('matricule', EntityType::class,['class'=>Endroit::class,'choice_label'=>'idEndroit'])

            ->add('dateDebut')
            ->add('dateFin')

            ->add('cautionnement')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
