<?php


namespace App\Interfaces\ShoppingCart;

interface IShoppingCart{

    public function addToCart($data);
    public function getCartByUser();
    public function updateProductQuantity($product_id);
    public function deleteFromCart($product_id);
}
