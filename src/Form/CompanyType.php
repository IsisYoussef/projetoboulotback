<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->add('password', PasswordType::class, [
                "mapped" => false,
                "label" => "Votre mot de passe",
            ])
            ->add('gender', ChoiceType::class, [
                "multiple" => false,
                "expanded" => true,
                "choices" => [
                    "Madame" => "Madame",
                    "Monsieur" => "Monsieur",
                    "Autre" => "Autre"
                ]
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
            ->add('address', TextType::class, [
                "label" => "Adresse",
                "attr" => [
                    "placeholder" => "Votre adresse"
                ]
            ])
            ->add('postalCode', TextType::class, [
                "label" => "Code postal",
                "attr" => [
                    "placeholder" => "Code postal"
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville",
                "attr" => [
                    "placeholder" => "Votre ville"
                ]
            ])
            ->add('presentation', TextType::class, [
                "label" => "présentation"
            ])
            ->add('siret')
            ->add('logo')
            ->add('name', TextType::class, [
                "label" => "nom de l'entreprise"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
