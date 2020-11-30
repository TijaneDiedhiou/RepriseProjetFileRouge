<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserServices;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    private $password;
   
    /**
     * @Route(
     *      name="add_user",
     *      path="/api/admin/users",
     *      methods="POST",
     *      
     * )
     */
    public function addUser(Request $request,UserServices $UserServices, EntityManagerInterface $manager ){
        $user = $UserServices->addUser($request);
        $manager->persist($user);
        $manager ->flush();
        return $this->json($user,Response::HTTP_CREATED);

    }
      
     /**
     * @Route(
     *      name="update",
     *      path="/api/admin/users/{id}",
     *      methods="PUT",
     * )
     */
    public function update(int $id, UserServices $userServices,Request $request,EntityManagerInterface $manager,UserRepository $userRepo)
    {
        $user = $userServices->update($id,$request,$userRepo);
        $manager->persist($user);
        $manager ->flush();
        return $this->json($user,Response::HTTP_CREATED);

    }

     
            
    

}