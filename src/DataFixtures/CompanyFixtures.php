<?php

namespace App\DataFixtures;

use App\Entity\Company;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //---- Creation Company ----

        $company = new Company();
        $company->setEmail("entreprise@recrut.com");

        // mot de passe entreprise
        $company->setPassword('$2y$13$7GrYE5KTBth3p/9s8OijaeoIqF5Jd8uxIWHXY8ZCSjYypw0nH3kOa');
        $company->setName("O'boulot");
        $company->setSiret("80365956985425");
        $company->setFirstname("GÃ©rad");
        $company->setLastname("Duroy");
        $company->setPhone("0145859696");
        $company->setAddress("rue de la riviere");
        $company->setPostalCode("13000");
        $company->setCity("Marseille");
        $company->setpresentation("Entreprise depuis 5ans au service de la personne");
        $company->setCreatedAt(new Datetime("2023-09-04"));
        $company->setRoles(['ROLE_COMPANY']);

        $manager->persist($company);

        $faker = \Faker\Factory::create();
        $fakerFr = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Faker\Provider\fr_FR\Company($faker));

        //50 entreprises
        /** @var Company[] */
        $allCompanies = [];
        for ($i=0; $i < 50; $i++) {

            //1. nouvelle instance
            $newCompany = new Company();

            //2. remplir les propriétés
            $newCompany->setEmail($faker->freeEmail());
            $newCompany->setPassword("company");
            $newCompany->setName($faker->company());
            $newCompany->setSiret($faker->siret());
            $newCompany->setFirstname($fakerFr->firstName());
            $newCompany->setLastname($fakerFr->lastName());
            $newCompany->setPhone($fakerFr->phoneNumber());
            $newCompany->setAddress($fakerFr->Address());
            $newCompany->setPostalCode("75000");
            $newCompany->setCity("Paris");
            $newCompany->setpresentation("Entreprise dynamique, humaine et innovante");
            $newCompany->setCreatedAt(new Datetime('now'));
            $newCompany->setRoles(['ROLE_COMPANY']);

            $manager->persist($newCompany);
        }

        $manager->flush();
    }
}
