<?php

namespace App\Service;

use App\Entity\Product;
use App\Interfaces\Crud\IAddProduct;
use App\Interfaces\Crud\IAvailableProducts;
use App\Interfaces\FormValidator\IValidateForm;
use Doctrine\ORM\EntityManagerInterface;

class CrudService implements IValidateForm, IAddProduct, IAvailableProducts
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ValidateForm(Product $product): array
    {
        //esta validación es provicional ya que hacer una
        $isValid = true;
        $errorMessages = ['name'=>'','description'=>'','price'=>''];
        if($product->getName() == null ||  strlen($product->getName()) < 3 ){
            $errorMessages ['name'] = 'campo nombre vacio o con largo menor 3 ';
            $isValid = false;
        }

        if($product->getDescription() == null){
            $errorMessages['description'] = 'campo vacio';
            $isValid = false;
        }

        if($product->getPrice() == 0 || $product->getPrice() == null){
            $errorMessages['price'] = 'campo vacio';
            $isValid = false;
        }


        return ['is_valid'=>$isValid,'error_messages'=>$errorMessages];
    }

    public function addProduct(Product $product): array
    {
        return $isProductAdded = $this->entityManager->getRepository(Product::class)->addProduct($product);
    }

    public function getAvailableProducts(): array
    {
        return $this->entityManager->getRepository(Product::class)->getAvailableProducts();

    }
}