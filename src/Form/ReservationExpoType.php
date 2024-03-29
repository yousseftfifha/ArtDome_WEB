<?php

namespace App\Form;

use App\Entity\Exposition;
use App\Entity\ReservationExpo;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservationExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlace', TextType::class,array(
                'label'=>'Nombre de places à réserver ',
                'attr'=>[
                    'placeholder'=>'Entrer le nombre de place que vous souhaitez réserver...'
                ]
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationExpo::class,
        ]);
    }
}
