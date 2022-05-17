<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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
    public function registerNewUser(Request $request,UserService $userService): JsonResponse
    {

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

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=> function ($object,$format,$context){
            return $object;
            }
        ];

        $normalizer = new ObjectNormalizer(null,null,null,null,null,null,$defaultContext);
        $serializer = new Serializer([$normalizer],[$encoder]);
        $user = $serializer->serialize($currentUser,'json');

        return $this->json(['user'=> $user,
            'isAuth'=>$isAuthenticated],200);
    }
}
