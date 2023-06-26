<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Job;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entitled', TextType::class, [
                "label" => "intitulé",
                "attr" => [
                    "placeholder" => "intitulé du poste"
                ]
            ])
            ->add('dateFrom', DateTimeType::class,  [
                "label" => "Date de début de la mission"
            ])
            ->add('dateTill', DateTimeType::class,  [
                "label" => "Date de fin de la mission"
            ])
            ->add('duration', TextType::class, [
                "label" => "Durée de la mission (si moins de 10 heures consécutives)",
                "attr" => [
                    "placeholder" => "Durée mentionnée en heure"
                ]
            ])
            ->add('nbVacancy', IntegerType::class, [
                "label" => "Nombre de postes à pourvoir",
                "attr" => [
                    "placeholder" => "Inscrire uniquement le chiffre ici"
                ]
            ])
            ->add('place', TextType::class, [
                "label" => "Lieu de la mission",
                "attr" => [
                    "placeholder" => "Mentionner l'adresse, le code postal et la ville de la mission"
                ]
            ])
            ->add('description', TextType::class, [
                "label" => "Description",
                "attr" => [
                    "placeholder" => "Détails de la mission"
                ]
            ])
            ->add('category', EntityType::class, [
                "label" => "Catégorie du poste",
                "multiple" => false,
                "expanded" => false,
                "class" => Category::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
