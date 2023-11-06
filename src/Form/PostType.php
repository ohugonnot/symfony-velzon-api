<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu'
            ])
            ->add('dateFrom', DateTimeType::class, [
                "input" => 'datetime',
                'data' => new \DateTime(),
                'label' => 'Date de publication',
                'widget' => 'single_text',
                'attr' => [
                    'data-provider' => "flatpickr",
//                    'data-altFormat' => "d/m/Y",
                ]
            ])
            ->add('dateTo', DateTimeType::class, [
                "input" => 'datetime',
                'required' => false,
                'label' => 'Date de fin (facultatif))',
                'widget' => 'single_text',
                'attr' => [
                    'data-provider' => "flatpickr",
//                    'data-altFormat' => "d/m/Y",
                ]
            ])
            ->add('featuredImg', FileType::class, [
                'label' => 'Image de couverture',
                'required' => false,
                'data_class' => null
            ])
//            ->add('postedBy')
            ->add('status', CheckboxType::class, [
                'label' => 'Publié',
                'data' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
