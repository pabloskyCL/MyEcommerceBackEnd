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
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
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
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
