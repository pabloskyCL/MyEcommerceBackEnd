<?php

namespace App\Interfaces\Crud;
use App\Entity\Product;

interface IAddProduct {
    public function  addProduct(Product $product);
}