<?php

namespace App\Form;

use App\Entity\Reservationevent;
use App\Entity\User;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationeventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlace')
            ->add('codeClient', EntityType::class,['class'=>User::class,'choice_label'=>'id'])
            ->add('codeEvent', EntityType::class,['class'=>Event::class,'choice_label'=>'nom_event'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservationevent::class,
        ]);
    }
}
