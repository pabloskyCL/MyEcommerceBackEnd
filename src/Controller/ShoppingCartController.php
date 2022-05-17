<?php

namespace App\Controller;

use App\Service\ShoppingCartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/api/addToCart", name="add_to_cart")
     *
     */
    public function addToCart(Request $request, ShoppingCartService $shoppingCartService){
        $data = json_decode($request->getContent());
        $response = [];
        if($data){
            $response = $shoppingCartService->addToCart($data);
        }


        return new JsonResponse($response);
    }

    /**
     * @Route("/api/getCart", name="get_cart")
     *
     */
    public function getCart(ShoppingCartService $shoppingCartService): JsonResponse
    {
        return new JsonResponse($shoppingCartService->getCartByUser());
    }

    /**
     * @Route("/api/updateProductQuantity")
     *
     */
    public function updateProductQuantity(ShoppingCartService $shoppingCartService, Request $request): JsonResponse
    {
        $product = json_decode($request->getContent());
        $result = ['updated' =>$shoppingCartService->updateProductQuantity($product->id),'message'=>'producto agregado'];
        return new JsonResponse($result,201);
    }

    /**
     * @Route("/api/deleteProduct")
     */
    public function deleteFromCart(Request $request, ShoppingCartService $shoppingCartService): JsonResponse
    {
            $productId = json_decode($request->getContent());
            $result = ['isEliminated' => $shoppingCartService->deleteFromCart($productId)];
            return new JsonResponse($result, 201);
    }
}
