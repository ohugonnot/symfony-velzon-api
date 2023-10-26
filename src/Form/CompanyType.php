<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('adress')
            ->add('city')
            ->add('country')
            ->add('email')
            ->add('phone')
            ->add('contacts')
            ->add('files', EntityType::class, [
                'class' => File::class,
                'choice_label' => 'fileName',
                'multiple' => true,
                'required' => false,
                'expanded' => false,
            ])
            ->add('added_files', CollectionType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'added files',
                'entry_type' => StoredFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ])
            ->add('active');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
