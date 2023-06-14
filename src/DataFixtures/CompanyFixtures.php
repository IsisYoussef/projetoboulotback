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

        $manager->flush();
    }
}
