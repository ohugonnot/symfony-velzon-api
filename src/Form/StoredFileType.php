<?php

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoredFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => false,
                'mapped' => true
            ])
//            ->add('file', FileType::class, ['label' => false])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Documents' => 'Documents',
                    'Media' => 'Media',
                    'Recent' => 'Recent',
                    'Important' => 'Important',
                    'Deleted' => 'Deleted'
                ]
            ])
            ->add('starred', CheckboxType::class, [
                'label' => 'Favoris o/n',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
