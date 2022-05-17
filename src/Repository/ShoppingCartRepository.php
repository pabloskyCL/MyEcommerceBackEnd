<?php

namespace App\Repository;

use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCart[]    findAll()
 * @method ShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ShoppingCart $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ShoppingCart $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function addProductToCart($user_id, $product): bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'INSERT INTO shopping_cart (id_user_id,id_product_id,cantidad) VALUES (:user_id,:product_id,:cantidad)';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executequery(['user_id'=>$user_id,'product_id'=>$product->id,'cantidad'=>$product->cantidad]);
        return (bool)$resultSet->rowCount();
    }

//    public function updateProductQuantity($product_id,$quantity): bool
//    {
//        // filtrar por usuarios también
//        $conn = $this->getEntityManager()->getConnection();
//        $sql = 'UPDATE shopping_cart SET cantidad = :quantity WHERE id_product_id = :productId';
//        $stmt = $conn->prepare($sql);
//        $resultSet = $stmt->executeQuery(['quantity'=>$quantity,'productId'=>$product_id]);
//        return (bool)$resultSet->rowCount();
//    }

    public function addProductFromCart($product_id,$user_id): bool
    {
        // filtrar por usuarios también
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE shopping_cart SET cantidad = cantidad+1 WHERE id_product_id = :productId AND id_user_id = :user_id';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['productId'=>$product_id, 'user_id' => $user_id]);
        return (bool)$resultSet->rowCount();
    }


    public function getCartByUser($user_id): array
    {
        $conn = $this->getEntityManager()->getconnection();
        $sql = 'select p.id as id
                     ,u.id as id_usuario
                     ,sc.cantidad
                     ,p.name
                     ,p.price
                     ,p.image 
                from shopping_cart sc 
                    join user u on sc.id_user_id = u.id 
                    join product p on sc.id_product_id = p.id
                where u.id = :userId;';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId'=>$user_id])->fetchAllAssociative();

        return $resultSet;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function deleteProductFromCart($product_id, $user_id): bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'delete from shopping_cart where id_product_id = :product_id and id_user_id = :user_id';
        $stmt = $conn->prepare($sql);
        return  (bool)$stmt->executeQuery(['product_id' => $product_id , 'user_id'=>$user_id])->rowCount();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function deleteOneProductFromCart($product_id, $user_id): bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE shopping_cart SET cantidad = cantidad-1 WHERE id_product_id = :productId AND id_user_id = :user_id';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['productId'=>$product_id, 'user_id'=> $user_id]);
        return (bool)$resultSet->rowCount();
    }
    // /**
    //  * @return ShoppingCart[] Returns an array of ShoppingCart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShoppingCart
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
