<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this -> password = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=1; $i <2 ; $i++) { 
         $admin = new Admin();
         $admin -> setPrenom($faker -> firstName)
                -> setNom($faker -> lastName)
                ->setIsDeleted(0)
                -> setEmail($faker -> email);
         $pass  =  $this -> password -> encodePassword($admin, "Emitey");
         $admin -> setPassword($pass);
         $admin -> setProfil($this->getReference(ProfilFixtures::PROFIL_ADMIN_REFERENCE));
         $manager -> persist($admin);

         $formateur = new Formateur();
         $formateur -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email);
         $pass  =  $this -> password -> encodePassword($formateur, "Emitey");
         $formateur -> setPassword($pass);
         $formateur -> setProfil($this->getReference(ProfilFixtures::PROFIL_FORMATEUR_REFERENCE));
         $manager -> persist($formateur);

         $apprenant = new Apprenant();
         $apprenant -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email);
         $pass  =  $this -> password -> encodePassword($apprenant, "Emitey");
         $apprenant -> setPassword($pass);
         $apprenant -> setProfil($this->getReference(ProfilFixtures::PROFIL_APPRENANT_REFERENCE));
         $manager -> persist($apprenant);

         $cm = new Cm();
         $cm -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email);
         $pass  =  $this -> password -> encodePassword($cm, "Emitey");
         $cm -> setPassword($pass);
         $cm -> setProfil($this->getReference(ProfilFixtures::PROFIL_CM_REFERENCE));
         $manager -> persist($cm);
        }
        
        $manager -> flush();
    }
}