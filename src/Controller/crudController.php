<?php

namespace App\Controller;

use App\Entity\Product;
use App\FormTypes\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class crudController extends AbstractController {

//    /**
//     * @Route("/addProduct", name="add_product")
//     *
//     * @return Response
//     */
//    public function AddProductAction(EntityManagerInterface $doctrine, Request $request) :Response {
//        try {
//
//           // $result = $doctrine->getRepository(Product::class)->addProduct($product);
//        } catch (\Exception $e)
//        {
//
//            return new Response('ha ocurrido un error ...'.$e->getMessage());
//        }
//
//        return new Response(''.$result['status']);
//    }

    /**
     * @Route("/deleteProduct", name="delete_product")
     */
    public function deleteProductAction(EntityManagerInterface $entityManager, Request $request) :Response{

        $product_id = $request->get('product_id_delete',null);
        $product_name = $request->get('product_name_delete', null);
        $product_description = $request->get('product_description_delete', null);
        $product_price = $request->get('product_price_delete', null);
        $product = ['id'=>$product_id,'name'=>$product_name,'description'=>$product_description,'price'=>$product_price];
        $entityManager->getRepository(Product::class)->deleteProduct($product);
        $errorMessages = ['name'=>'','description'=>'','price'=>''];
        return $this->redirectToRoute('home_page',['message'=>$errorMessages]);

    }

    /**
     * @Route("/listProducts", name="list_product")
     * @return Response
     */
    public function listProductsAction() :Response{
        return $this->render();
    }

    /**
     * @Route("/getProduct", name="get_product")
     * @return Response
     */
    public function getProductAction() :Response{
       return $this->render();
    }


}
