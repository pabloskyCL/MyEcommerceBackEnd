<?php

namespace App\Controller;

use App\Interfaces\Crud\IAvailableProducts;
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
    public function getProductsAction(IAvailableProducts $AvailableProducts):Response{
        $products = $AvailableProducts->getAvailableProducts();
        return new JsonResponse($products);
    }

}