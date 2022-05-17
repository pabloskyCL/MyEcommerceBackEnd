<?php

namespace App\Controller;

use App\Service\homeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class HomeController extends AbstractController{

    /**
     * @Route ("/ListProducts", name="list_products")
     *
     */
    public function getProductsAction(HomeService $homeService):Response{
        $products = $homeService->getAvailableProducts();
        return new JsonResponse($products);
    }

}