<?php

namespace App\Service;

use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetenceService
{
    protected  $serializer;
    protected  $manager;

    public function __construct( SerializerInterface $serializer,EntityManagerInterface $manager  ) 
    {
        $this->serializer=$serializer;

    }

public function add_grpeCompetence(Request $req){
        $grpeCompetence = new GroupeCompetence;
        //dd($grpeCompetence);
       /* if(!$this-> isGranted('CREATE', $grpeCompetence)){
            return $this->json([
                "message" => "Vous n'avez pas accès à cette ressource"
            ], Response::HTTP_FORBIDDEN);
        }*/
        
       /* $grc = json_decode($req->getContent(), true);
        if(!empty($grc["competences"])){
            $competences = $this->denormalizer->denormalize($grc["competences"], "App\Entity\Competence[]");
            foreach($competences as $cmpt){
                $grpeCompetence->addCompetence($cmpt);
            }
        }else{
            return $this->json(["message" => "Ajouter au moins une compétence"], Response::HTTP_BAD_REQUEST);
        }
        $grpeCompetence
            ->setLibelle($grc["libelle"])
            ->setDescriptif($grc["descriptif"]);

        $errors = $this->validator->validate($grpeCompetence);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }

        $this->em->persist($grpeCompetence);
        $this->em->flush();
        return $this->json($grpeCompetence, Response::HTTP_CREATED);*/
    }
}