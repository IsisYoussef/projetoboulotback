<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CandidateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //---- Creation Candidate ----

        $candidate = new Candidate();
        $candidate->setEmail("candidat@unsite.com");

        // mot de passe julie
        $candidate->setPassword('$2y$13$Dt.3iMjSc9fHE8YXzh3o0.8qo.i1EpoTHqBcQOpmFajr8gIyJEfHa');
        $candidate->setFirstname("Julie");
        $candidate->setLastname("Martin");
        $candidate->setBirthday(new DateTime("1987-05-24"));
        $candidate->setPhone("0612565896");
        $candidate->setAddress("rue de Paris");
        $candidate->setPostalCode("75008");
        $candidate->setCity("Paris");
        $candidate->setpresentation("Candidate extremement motivé");
        $candidate->setCreatedAt(new Datetime("2023-09-04"));
        $candidate->setRoles(['ROLE_CANDIDATE']);

        $manager->persist($candidate);


        $manager->flush();
    }
}
