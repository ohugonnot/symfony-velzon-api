<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'required' => false,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('f')
                        ->andWhere("f.category like 'Vehicles'");
                },
                'choice_label' => 'fileName',
                'multiple' => true,
            ])
            ->add('uploaded_files', CollectionType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Upload files',
                'entry_type' => NoCategoryFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
