<?php

namespace App\Service;

use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GroupeCompetenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GroupeCompetenceService
{
    protected  $serializer;
    protected  $manager;

    public function __construct( SerializerInterface $serializer,EntityManagerInterface $manager,DenormalizerInterface $denormalizer) 
    {
        $this->serializer=$serializer;
        $this->dernomalizer=$denormalizer;
    }
    public function update_grpecompetence($id, GroupeCompetenceRepository $repo){
        $grpc = $repo->find($id);
        $grcTab = json_decode($req->getContent(), true);
    }
}