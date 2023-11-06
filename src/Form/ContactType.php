<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('notes', TextareaType::class, [
                'label' => 'Notes',
                'required' => false
            ])
            ->add('active')
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'mapped' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.active = true");
                },
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('newtags', CollectionType::class, [
                'mapped' => false,
                'required' => false,
                'entry_type' => TagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false
            ])
            ->add('companies', EntityType::class, [
                'class' => Company::class,
                'mapped' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->andWhere("c.active = true");
                },
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false
            ])
            ->add('newcompanies', CollectionType::class, [
                'mapped' => false,
                'required' => false,
                'entry_type' => CompanyType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
