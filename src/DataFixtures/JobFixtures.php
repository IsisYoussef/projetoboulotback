<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Job;
use App\Entity\Company;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class JobFixtures extends Fixture
{
    public $companyRepository;
    public $categoryRepository;

    public function __construct(CompanyRepository $companyRepository, CategoryRepository $categoryRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();

        $allCompanies = $this->companyRepository->findAll();
        $allCategories = $this->categoryRepository->findAll();

        for ($i=0; $i <50; $i++) {
            $newJob = new Job();
            $company = $allCompanies[mt_rand(0, count($allCompanies)-1)];
            $category = $allCategories[mt_rand(0, count($allCategories)-1)];

            $newJob->setEntitled("Offre n°" . $i . " - " . $faker->jobTitle());
            $newJob->setDateFrom(new DateTime("2023-02-03"));
            $newJob->setDateTill(new DateTime("2023-02-13"));
            $newJob->setNbVacancy(mt_rand(1, 5));
            $newJob->setPlace("Région parisienne");
            $newJob->setDescription("lorem ipsum synopsis");
            $newJob->setIsValid(true);
            $newJob->setCreatedAt(new DateTime('now'));
            $newJob->setPublishedAt(new DateTime('now'));
            $newJob->setCategory($category);
            $newJob->setCompany($company);

            $manager->persist($newJob);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
