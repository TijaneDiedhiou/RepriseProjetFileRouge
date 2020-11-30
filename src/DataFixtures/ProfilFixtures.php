<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixtures extends Fixture
{
    public const PROFIL_ADMIN_REFERENCE = 'ADMIN';
    public const PROFIL_FORMATEUR_REFERENCE = 'FORMATEUR';
    public const PROFIL_APPRENANT_REFERENCE = 'APPRENANT';
    public const PROFIL_CM_REFERENCE = 'CM';

    public function load(ObjectManager $manager)
    {
       
        $profilAdmin = new Profil();
        $profilAdmin -> setLibelle("ADMIN")
                     -> setIsDeleted(0);
        $this->addReference(self::PROFIL_ADMIN_REFERENCE, $profilAdmin);
        $manager -> persist($profilAdmin);
            
        $profilApprenant = new Profil();
        $profilApprenant -> setLibelle("APPRENANT")
                         -> setIsDeleted(0);
        $this->addReference(self::PROFIL_APPRENANT_REFERENCE, $profilApprenant);
        $manager -> persist($profilApprenant);

        $profilFormateur = new Profil();
        $profilFormateur -> setLibelle("FORMATEUR")
                         -> setIsDeleted(0);
        $this->addReference(self::PROFIL_FORMATEUR_REFERENCE, $profilFormateur);
        $manager -> persist($profilFormateur);

        $profilCM = new Profil();
        $profilCM -> setLibelle("CM")
                 -> setIsDeleted(0);
        $this->addReference(self::PROFIL_CM_REFERENCE, $profilCM);
        $manager -> persist($profilCM);

        $manager->flush();
    }
}