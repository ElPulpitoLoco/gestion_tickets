<?php

namespace App\DataFixtures;

use App\Entity\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatutFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $statuts = ['Nouveau', 'Ouvert', 'Résolu', 'Fermé'];

        foreach ($statuts as $nom) {
            $statut = new Statut();
            $statut->setNom($nom);
            $manager->persist($statut);
        }

        $manager->flush();
    }
}
