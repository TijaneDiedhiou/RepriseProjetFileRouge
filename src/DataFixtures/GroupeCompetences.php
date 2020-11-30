<?php

namespace App\DataFixtures;

use App\Entity\GroupeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GroupeCompetences extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $grpcompetence=new GroupeCompetence();
        $grpcompetence
            ->setLibelle('developper le front-end ')
            ->setDescriptif('descriptif');
      
        $manager->persist($grpcompetence);

        $manager->flush();
    }
}
