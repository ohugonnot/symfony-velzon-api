<?php

namespace App\Form;

use App\Entity\Objectif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('month', ChoiceType::class, [
                'choices' => [
                    'Janvier' => 1,
                    'Février' => 2,
                    'Mars' => 3,
                    'Avril' => 4,
                    'Mai' => 5,
                    'Juin' => 6,
                    'Juillet' => 7,
                    'Apût' => 8,
                    'Septembre' => 9,
                    'Octobre' => 10,
                    'Novembre' => 11,
                    'Décembre' => 12,
                ]
            ])
            ->add('year', ChoiceType::class, [
                'choices' => [
                    '2023' => 2023,
                    '2024' => 2024,
                    '2025' => 2025
                ]
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [
                    'Chassieu' => 'chassieu',
                    'Equipement' => 'equipement'
                ]
            ])
            ->add('objectif');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objectif::class,
        ]);
    }
}
