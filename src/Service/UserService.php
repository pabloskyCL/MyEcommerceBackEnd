<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserService {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchNewUser($user): array
    {
        $status=[];
        try {
           $user = $this->validateUser($user);
            if($this->entityManager->getRepository(User::class)->registerNewUser($user)){
              $status = ['status'=>'ok'];
            }

        }catch ( Exception $ex){
             $status = ['status'=>'error','message'=>$ex->getMessage(),'code'=>$ex->getCode()];
        }

        return $status;

    }

    /**
     * @throws Exception
     */
    public function validateUser($user){
        if(!$user['first_name'] || $user['first_name'] == ''){
            throw new Exception('name_not_defined',401);
        }

        if(!$user['last_name'] || $user['last_name'] == ''){
            throw new Exception('last_name_not_defined',402);
        }

        if(!$user['email'] || $user['email'] == ''){
            throw new Exception('email_not_defined',403);
        }

        if(!$user['password'] || $user['password'] == ''){
            throw new Exception('password_not_defined',405);
        }

        if(!$user['direction'] || $user['direction']==''){
            $user['direction']= null;
        }else{
            $user['direction'] = $user['direction'].','.$user['region'].','.$user['comuna'].','.$user['postal_code'];
        }


        return $user;
    }

}