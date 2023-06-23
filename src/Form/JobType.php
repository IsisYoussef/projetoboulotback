<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entitled')
            ->add('dateFrom')
            ->add('dateTill')
            ->add('duration')
            ->add('nbVacancy')
            ->add('place')
            ->add('description')
            ->add('category', EntityType::class, [
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
