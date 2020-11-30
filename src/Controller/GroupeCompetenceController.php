<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\GroupeCompetenceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeCompetenceController extends AbstractController
{
   /**
     * @Route(
     *      name="add_grpecompetence",
     *      path="/api/admin/grpecompetences",
     *      methods="POST",
     *      defaults={
     *          "_controller"="\app\GroupeCompetenceController::add_grpecompetence",
     *           "_api_resource_class"=GroupeCompetence::class,
     *           "_api_collection_operation_name"="add_grpecompetence"
     *      }
     * )
     */
     /**
     * @Route(
     *      name="add_grpecompetence",
     *      path="/api/admin/grpecompetences",
     *      methods="POST",
     *      defaults={
     *          "_controller"="\app\GroupeCompetenceController::createGrpCompetence",
    *           "_api_resource_class"=GroupeCompetence::class,
    *           "_api_collection_operation_name"="add_grpecompetence"
     *      }
     * )
     */
    public function add_grpecompetence(Request $req){
        $grpeCompetence = new GroupeCompetence;

      // dd($grpeCompetence);
        $grc = json_decode($req->getContent(), true);
        dd($grc);

       
    }

}
