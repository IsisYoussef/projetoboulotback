<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Votre email",
            ])
            ->add('roles')
            ->add('password', PasswordType::class, [
                "label" => "Votre mot de passe",
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Votre nom"
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
            ->add('siret')
            ->add('logo')
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
