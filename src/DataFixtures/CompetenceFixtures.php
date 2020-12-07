<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompetenceFixtures extends Fixture implements DependentFixtureInterface
{
    public CONST COMPETENCE_REF="competence";
    public function load(ObjectManager $manager)
    {
        $nbr_skills=7;
        for ($i=0; $i < $nbr_skills; $i++) { 
            $skills=new Competence();
            $skills->setLibelle("Lorem Ipsum is simply dummy text of the printing".$i);
            $skills->setDescriptif("Lorem Ipsum is simply dummy text of the printing".$i);
            for ($j=0; $j < 3; $j++) {
                $skills->addNiveau($this->getReference(NiveauFixtures::NIVEAU_REF."$i"."_"."$j"));
            }      
            $this->setReference(self::COMPETENCE_REF.$i,$skills);
            $this->addReference(self::COMPETENCE_REF."$i"."_"."$j",$skills);
            $manager->persist($skills);
        }
        $manager->flush();
    }
    public function getDependencies () {
        return array(NiveauFixtures::class);
    }
}
