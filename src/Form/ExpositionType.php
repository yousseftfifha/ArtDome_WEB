<?php

namespace App\Form;


use App\Entity\Endroit;
use App\Entity\Exposition;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ExpositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomExpo', TextType::class,array(
                'label'=>'Nom Exposition',
                'attr'=>[
                    'placeholder'=>'Entrer le nom...'
                ]
            ))
            ->add('themeExpo', TextType::class,array(
                'label'=>'Thème Exposition',
                'attr'=>[
                    'placeholder'=>'Sélectionner le thème...'
                ]
            ))
            ->add('dateExpo', TextType::class,array(
                'label'=>'Date Exposition',
                'attr'=>[
                    'placeholder'=>'Entrer la date ...'
                ]
            ))
            ->add('nbMaxParticipant', TextType::class,array(
                'label'=>'Nombre Max de Participants',
                'attr'=>[
                    'placeholder'=>'Entrer le Nombre Max...'
                ]
            ))
            ->add('codeArtiste',EntityType::class,['class'=>User::class,'choice_label'=>'nom'], TextType::class,array(
                'label'=>'Nom Artiste'
            ))
            ->add('codeEspace', EntityType::class,['class'=>Endroit::class,'choice_label'=>'type'], TextType::class,array(
                'label'=>'Nom Espace'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exposition::class,
        ]);
    }
}
