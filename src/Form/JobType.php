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
            ->add('isValid')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('publishedAt')
            //->add('company', EntityType::class, [
            //   "multiple" => false,
            //    "expanded" => true,
            //    "class" => Company::class,
            //    'choice_label' => 'company',
            //])
            //->add('category', EntityType::class, [
            //    "multiple" => false,
            //    "expanded" => true,
            //    "class" => Category::class,
            //    'choice_label' => 'category',
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
