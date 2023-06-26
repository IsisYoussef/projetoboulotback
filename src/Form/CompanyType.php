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
                "label" => "Email du contact",
            ])
            ->add('password', PasswordType::class, [
                "mapped" => false,
                "label" => "Mot de passe du contact",
            ])
            ->add('gender', ChoiceType::class, [
                "label" => "Civilité du contact",
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
                    "placeholder" => "Prénom du contact"
                ]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Nom du contact"
                ]
            ])
            ->add('phone')
            ->add('address', TextType::class, [
                "label" => "Adresse",
                "attr" => [
                    "placeholder" => "Adresse de l'entreprise"
                ]
            ])
            ->add('postalCode', TextType::class, [
                "label" => "Code postal",
                "attr" => [
                    "placeholder" => "Code postal de l'entreprise"
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville",
                "attr" => [
                    "placeholder" => "Ville de l'entreprise"
                ]
            ])
            ->add('presentation', TextType::class, [
                "label" => "Présentation de l'entreprise"
            ])
            ->add('siret')
            ->add('logo')
            ->add('name', TextType::class, [
                "label" => "Nom de l'entreprise"
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
