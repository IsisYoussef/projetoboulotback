<?php

namespace App\Form;

use App\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email",
            ])
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
            ])
            ->add('gender', ChoiceType::class, [
                "label" => "Civilité",
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
                    "placeholder" => "Prénom du candidat"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Nom du candidat"
                ]
            ])
            ->add('phone', TextType::class, [
                "label" => "Numéro de téléphone",
                "attr" => [
                    "placeholder" => "Numéro de téléphone du candidat"
                ]
            ])

            ->add('address', TextType::class, [
                "label" => "Adresse",
                "attr" => [
                    "placeholder" => "Adresse du candidat"
                ]
            ])
            ->add('postalCode', TextType::class, [
                "label" => "Code postal",
                "attr" => [
                    "placeholder" => "Code postal du candidat"
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville",
                "attr" => [
                    "placeholder" => "Ville du candidat"
                ]
            ])
            ->add('presentation', TextType::class, [
                "label" => "Présentation du candidat"
            ])
            ->add('birthday', DateTimeType::class, [
                "label" => "Date de naissance du candidat"
            ])
            ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
