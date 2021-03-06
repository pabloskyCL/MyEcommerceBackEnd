<?php

namespace App\Service;


use App\Entity\ShoppingCart;
use App\Interfaces\Auth\IAuthenticatedUser;
use App\Interfaces\ShoppingCart\IShoppingCart;
use Doctrine\ORM\EntityManagerInterface;

class ShoppingCartService implements IShoppingCart {

    private EntityManagerInterface $entityManager;
    private IAuthenticatedUser $security;

    public function __construct(EntityManagerInterface $entityManager, IAuthenticatedUser $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function addToCart($data): array
    {
        $user = $this->security->getAuthenticatedUser();
        $response = null;
        $isAddedProduct = false;

        if($user){
            $isAddedProduct = $this->entityManager->getRepository(ShoppingCart::class)->addProductToCart($user->getId(),$data);
        }

        return [
            'message'=> $isAddedProduct ? 'producto agregado al carrito': 'ups no se puede agregar al carrito'
            , 'isAdded'=>$isAddedProduct
        ];
    }

    public function getCartByUser(): array
    {
        $user = $this->security->getAuthenticatedUser();
        return $this->entityManager->getRepository(ShoppingCart::class)->getCartByUser($user->getId());
    }

    public function updateProductQuantity($product_id): bool
    {
        $user = $this->security->getAuthenticatedUser();
        return $this->entityManager->getRepository(ShoppingCart::class)->addProductFromCart($product_id, $user->getId());
    }

    public function deleteFromCart($product_id): bool
    {
        $user = $this->security->getAuthenticatedUser();
        $cartRepository = $this->entityManager->getRepository(ShoppingCart::class);
        $product = $cartRepository->findOneBy(['idProduct' => $product_id, 'idUser'=> $user->getId()]);
        if($product && ($product->getCantidad() > 1)){
          return $cartRepository->deleteOneProductFromCart($product_id, $user->getId());
        }
        return $cartRepository->deleteProductFromCart($product_id,$user->getId());
    }
}
