<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class homeService {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAvailableProducts(): array
    {
        return $this->entityManager->getRepository(Product::class)->getAvailableProducts();

    }

}