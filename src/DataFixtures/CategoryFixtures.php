<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ["Evenementiel", "Secrétariat", "Administratif", "Batiment", "Restauration", "Saisie informatique", "Phoning","Archivage", "Street-marketing"];
        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->setTitle($category);

            $manager->persist($newCategory);

        }
        $manager->flush();
    }
}
