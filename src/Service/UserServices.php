<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserServices
{
    protected  $encoder;
    protected  $serializer;
    protected  $manager;

    public function __construct(UserPasswordEncoderInterface $encoder, SerializerInterface $serializer,EntityManagerInterface $manager  ) 
    {
        $this->serializer=$serializer;
        $this-> encoder = $encoder;

    }
  
    public function addUser(Request $request)
    {
        $userObject = $request->request->all();
        $avatar = $request->files->get('avatar');
        $avatar = fopen($avatar->getRealPath(), "r+");
        $userObject["avatar"] = $avatar;

        $user= $this-> serializer-> denormalize($userObject, "App\Entity\User");
        $user->setAvatar($avatar);
        $user->setPassword($this->encoder->encodePassword($user, "emitey"));
        return $user;


        
    }

    public function update($id,$request,$userRepo){
        $data= $request->request->all();
        $user=$userRepo->find($id);
        if($data["nom"]){
            $user->setNom($data["nom"]);
        }
        if($data["prenom"]){
            $user->setPrenom($data["prenom"]);
        }
        if ($data["email"]){
            $user->setEmail($data["email"]);
        }
        $uploadFile = $request->files->get('avatar');
        if ($uploadFile) {
            $file = $uploadFile->getRealPath();
            $avatar = fopen($file, 'r+');
            $user->setAvatar($avatar);
            # code...
        }
        return $user;
    }
}
