<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immat',)
            ->add('entryDate', DateType::class, [
                "input" => 'datetime_immutable',
                'label' => 'Date',
                'widget' => 'single_text',
                'attr' => [
                    'data-provider' => "flatpickr",
                    'data-altFormat' => "d/m/Y",
                ]
            ])
            ->add('marque')
            ->add('modele')
            ->add('carburant')
            ->add('numAssurance')
            ->add('active')
            ->add('employee')
            ->add('files', EntityType::class, [
                'class' => File::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('f')
                        ->andWhere('f.categories like');
                },
                'choice_label' => 'url',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
