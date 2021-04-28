<?php

namespace App\Form;

use App\Entity\Endroit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EndroitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices' => [
                    'Manoir' => 'Manoir',
                    'Salle expo'  => 'Salle expo'
                ],

                'label' => 'Type'
            ])

            ->add('taille')
            ->add('prixJour')
            ->add('nbrch')
            ->add('location')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Endroit::class,
        ]);
    }
}
