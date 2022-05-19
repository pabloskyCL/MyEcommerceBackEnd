<?php

namespace App\Interfaces\FormValidator;
use App\Entity\Product;

interface IValidateForm {
    public function validateForm(Product $product);
}