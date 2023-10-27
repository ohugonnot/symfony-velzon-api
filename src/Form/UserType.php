<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//            ->add('roles')
        $builder
            ->add('username')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('email')
            ->add('active')
//            ->add('privateFiles')
//            ->add('services')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
