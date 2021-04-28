<?php

namespace App\Form;

use App\Entity\Exposition;
use App\Entity\Oeuvre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomoeuvre')
            ->add('prixoeuvre')
            ->add('dateoeuvre')
            ->add('imageFile',FileType::class, array('label'=>'Picture','data_class' => null,'required' => false))            ->add('nomcat', EntityType::class,['class'=>Categorie::class,'choice_label'=>'nomcat'])
            ->add('emailartiste')
            ->add('codeExposition', EntityType::class,['class'=>Exposition::class,'choice_label'=>'codeExpo'])
            ->add('color',ColorType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}
