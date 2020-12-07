<?php

namespace App\DataFixtures;

use App\Entity\GroupeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupeCompetencesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $skills_groups=5;
        for ($i=0; $i < $skills_groups; $i++) { 
            $skill_group=new GroupeCompetence();
            $skill_group->setLibelle("Lorem Ipsum is simply dummy text of the printing".$i);
            $skill_group->setDescriptif("Lorem Ipsum is simply dummy text of the printing".$i);
            $nbr_skills=rand(1,4);
            for ($j=1; $j <= $nbr_skills; $j++) { 
                $skill_group->addCompetence($this->getReference(CompetenceFixtures::COMPETENCE_REF.$j));
            }
            $manager->persist($skill_group);
        }
        $manager->flush();
    }

    public function getDependencies () {
        return array(CompetenceFixtures::class);
    }
}
