<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NiveauFixtures extends Fixture
{
    public CONST NIVEAU_REF="niveau_";
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 7; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                $niveau=new Niveau();
                $niveau->setLibelle("Lorem Ipsum is simply dummy text of the printing".$j);
                $niveau->setGroupeAction("Lorem Ipsum is simply dummy text of the printing".$j);
                $niveau->setCritereEvaluation("Lorem Ipsum is simply dummy text of the printing".$j);
                $this->addReference(self::NIVEAU_REF."$i"."_"."$j",$niveau);
                $manager->persist($niveau);
            }           
            $manager->flush();
        }
    }   
}
