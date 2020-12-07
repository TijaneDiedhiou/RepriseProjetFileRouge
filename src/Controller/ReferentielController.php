<?php

namespace App\Controller;

use App\Service\ReferentielService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
      /**
     * @Route(
     *      name="AddReferentiel",
     *      path="api/admin/referentiels",
     *      methods="POST",
     *      
     * )
     */
  
    public function AddReferentiel(ReferentielService $referentielService, Request $request,EntityManagerInterface $manager): Response
    {
        $referentielTab = $request->request->all();
        $programme= $request->files->get("programme");
        $programmes= fopen($programme->getRealPath(), "r+");
        $reference=$this->serializer->denormalize($referentielTab, Referentiel::class,'json');
        $reference->setProgramme($programmes);
        foreach ($referenceTab['groupeCompetence'] as $groupeCompetence) {
            $groupe=$this->manager->getRepository(GroupeCompetence::class)->find($groupeCompetence);
            $reference->addGroupeCompetence($groupe);
        }

        $manager->persist($reference);
        $manager->flush();
        return new Json("succe", Response::HTTP_CREATED);
    }
}
