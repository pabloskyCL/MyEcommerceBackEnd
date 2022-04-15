<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooController extends AbstractController
{

    /**
     * @Route ("/testSymfonyApi", name="test_symfony_api")
     *
     */
    public function testAction(Request $request): Response {
        $responseTest = ['test'=>'hola mundo'];
        return new JsonResponse($responseTest);
    }

}