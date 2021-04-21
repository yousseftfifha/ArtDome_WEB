<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\Endroit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEvent',TextType::class,array(
        'label'=>'Event name',
        'attr'=>[
            'placeholder'=>'Enter a name...'
        ]
    ))
            ->add('themeEvent',ChoiceType::class, [
                'choices' => [
                    'Launching' => 'Launching',
                    'WorkShop' => 'WorkShop',
                    'Concert' => 'Concert',
                    'Color Fest' => 'Color Fest',
                    'Runway Show' => 'Runway Show',
                    'Book Singing' => 'Book Singing',
                    'Autre..' => 'Autre..',
                ],])
            ->add('etat',ChoiceType::class, [
                    'choices' => [
                    'Physique' => 'Physique',
                    'Digital' => 'Digital',
                ],])
            ->add('date',DateType::class,array(
                'label'=>'Event date',
                'attr'=>[
                    'placeholder'=>'Enter a date...'
                ]
            ))
            ->add('nbMaxPart')
            ->add('image'/*, FileType::class*/,TextType::class,array(
                'label'=>'Event picture',
                'attr'=>[
                    'placeholder'=>'Enter a picture path (This field will be changed into FileType field)...'
                ]
            ))
            ->add('video'/*,FileType::class*/,TextType::class,array(
                'label'=>'Event video',
                'attr'=>[
                    'placeholder'=>'Enter a video path (This field will be changed into FileType field)...'
                ]
            ))
            ->add('codeArtiste', EntityType::class,['class'=>User::class,'choice_label'=>'id'])
            ->add('codeEspace', EntityType::class,['class'=>Endroit::class,'choice_label'=>'idEndroit'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
