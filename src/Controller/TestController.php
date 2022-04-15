<?php

namespace App\Controller;

use App\Entity\Product;
use App\FormTypes\ProductType;
use App\Repository\ProductRepository;
use App\Service\AddProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class TestController extends AbstractController{

    /**
     * @Route("/home", name="home_page")
     *
     */
    public function indexPageAction(EntityManagerInterface $doctrine, Request $request, AddProductService $addProductService) :Response{
        $product = new Product();
        $errorMessages = ['name'=>'','description'=>'','price'=>''];
        $isFetchProduct = [];
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $validateFormStatus = $addProductService->ValidateForm($product);
            $errorMessages = $validateFormStatus['error_messages'];
            if($validateFormStatus['is_valid']){
                $isFetchProduct =$addProductService->addProduct($product);
            }
        }
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->renderForm('index.html.twig',
            ['products'=> $products,
             'form'=>$form,
                'form_status' => $isFetchProduct,
                'message'=> $errorMessages,
         ]);
    }

}