<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email pour se logger"
            ])
            ->add('roles', ChoiceType::class, [
                "multiple" => true,
                "expanded" => true,
                "choices" => [
                    "ADMIN" => "ROLE_ADMIN",
                    "MANAGER" => "ROLE_MANAGER",
                    "USER" => "ROLE_USER",
                ]
            ])
            ->add('password', PasswordType::class)
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "votre nom"
                ]
            ])
            ->add('phone')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('presentation', TextType::class, [
                "label" => "Présentation"
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('gender')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
