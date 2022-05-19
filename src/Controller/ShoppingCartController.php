<?php

namespace App\Controller;

use App\Interfaces\ShoppingCart\IShoppingCart;
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
    public function addToCart(Request $request, IShoppingCart $shoppingCartService){
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
    public function getCart(IShoppingCart $shoppingCartService): JsonResponse
    {
        return new JsonResponse($shoppingCartService->getCartByUser());
    }

    /**
     * @Route("/api/updateProductQuantity")
     *
     */
    public function updateProductQuantity(IShoppingCart $shoppingCartService, Request $request): JsonResponse
    {
        $product = json_decode($request->getContent());
        $result = ['updated' =>$shoppingCartService->updateProductQuantity($product->id),'message'=>'producto agregado'];
        return new JsonResponse($result,201);
    }

    /**
     * @Route("/api/deleteProduct")
     */
    public function deleteFromCart(Request $request, IShoppingCart $shoppingCart): JsonResponse
    {
            $productId = json_decode($request->getContent());
            $result = ['isEliminated' => $shoppingCart->deleteFromCart($productId)];
            return new JsonResponse($result, 201);
    }
}
