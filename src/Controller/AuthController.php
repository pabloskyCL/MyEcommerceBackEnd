<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class AuthController extends AbstractController
{
    private UserRepository $userRepository;
    private Security $security;
    private SerializerInterface $serializer;

    public function __construct(UserRepository $userRepository, Security $security, SerializerInterface $serializer)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->serializer = $serializer;
    }

    /**
     *@Route("/register", name="user.register")
     *
     */
    public function registerNewUser(Request $request,UserService $userService){

        $jsonData = json_decode($request->getContent());
        $user = $this->userRepository->create($jsonData);

        return new JsonResponse([
            'user' => $this->serializer->serialize($user,'json')
        ],201);
    }

    /**
     * @Route("/profile", name="user.profile")
     *
     */
    public function profile(): JsonResponse
    {
        $isAuthenticated = true;
        $currentUser = $this->security->getUser();
        if(!$currentUser){
           $isAuthenticated = false;
        }
        $user = $this->serializer->serialize($currentUser, 'json');

        return new JsonResponse(['user'=> $user,
            'isAuth'=>$isAuthenticated],200);
    }
}
