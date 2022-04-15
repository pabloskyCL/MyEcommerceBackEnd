<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function addProduct(Product $product): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'INSERT INTO product (name,price,description,in_stock) VALUES (:name,:price,:description,:in_stock)';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['name'=>$product->getName(),
                'price'=>$product->getPrice(),
                'description'=>$product->getDescription(),
                'in_stock'=> 0],
                [
                   ParameterType::STRING,
                   ParameterType::INTEGER,
                   ParameterType::STRING
                ]);
        return ($resultSet->rowCount()>0) ? ['status'=>'ok']: ['status'=>'error'];
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function deleteProduct($product): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'DELETE FROM product WHERE id = :id AND name = :name AND  price = :price AND description = :description';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id'=>$product['id'],'name'=>$product['name'],'price'=>$product['price'],'description'=>$product['description']]);
        return ($resultSet->rowCount()>0) ? ['status'=>'ok']: ['status'=>'error'];
    }



    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
