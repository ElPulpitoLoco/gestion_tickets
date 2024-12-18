<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Incident', 'Panne', 'Évolution', 'Anomalie', 'Information']; //liste cat demander

        foreach ($categories as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
