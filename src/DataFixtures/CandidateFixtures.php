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
        $candidate->setGender("Madame");
        $candidate->setFirstname("Julie");
        $candidate->setLastname("Martin");
        $candidate->setBirthday(new DateTime("1987-05-24"));
        $candidate->setPhone("0612565896");
        $candidate->setAddress("rue de Paris");
        $candidate->setpresentation("Candidate extremement motivé");
        $candidate->setPostalCode("75008");
        $candidate->setCity("Paris");
        $candidate->setCreatedAt(new Datetime("2023-09-04"));
        $candidate->setRoles(['ROLE_CANDIDATE']);



        $manager->persist($candidate);

        $faker = \Faker\Factory::create();
        $fakerFr = \Faker\Factory::create('fr_FR');


        //* 50 candidats masculins avec Fakers
        /** @var Candidate[] */
        $allCandidates = [];
        for ($i=0; $i < 50; $i++) {
            //1. nouvelle instance
            $newCandidate = new Candidate();
            //2. remplir les propriétés

            $newCandidate->setEmail($faker->freeEmail());
            $newCandidate->setPassword("candidat");
            $newCandidate->setGender("Monsieur");
            $newCandidate ->setFirstname($fakerFr->firstNameMale());
            $newCandidate ->setLastname($fakerFr->lastName());
            $newCandidate ->setBirthday($faker->datetime());
            $newCandidate ->setPhone($fakerFr->mobileNumber());
            $newCandidate ->setAddress($fakerFr->secondaryAddress());
            $newCandidate ->setPostalCode("75000");
            $newCandidate ->setCity("Paris");
            $newCandidate ->setCreatedAt(new Datetime('now'));
            $newCandidate ->setRoles(['ROLE_CANDIDATE']);


            $manager->persist($newCandidate);

            $allCandidates[] = $newCandidate;
        }

                //* 50 candidates femmes
        /** @var Candidate[] */
        $allCandidatesWomen = [];
        for ($i=0; $i < 50; $i++) {
            //1. nouvelle instance
            $newCandidateF = new Candidate();
            //2. remplir les propriétés

            $newCandidateF ->setEmail($faker->freeEmail());
            $newCandidateF ->setPassword("candidate");
            $newCandidateF ->setGender("Madame");
            $newCandidateF ->setFirstname($fakerFr->firstNameFemale());
            $newCandidateF ->setLastname($fakerFr->lastName());
            $newCandidateF ->setBirthday($faker->datetime());
            $newCandidateF ->setPhone($fakerFr->MobileNumber());
            $newCandidateF ->setAddress($fakerFr->Address());
            $newCandidateF ->setPostalCode("75000");
            $newCandidateF ->setCity("Paris");
            $newCandidateF ->setCreatedAt(new Datetime('now'));
            $newCandidateF ->setRoles(['ROLE_CANDIDATE']);


            $manager->persist($newCandidateF);

            $allCandidatesWomen[] = $newCandidateF;
        }
        $manager->flush();
    }
}
