<?php

namespace StoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{

    public function findLastProducts($limit)
    {
        return $this
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    public function findFamousProducts($limit)
    {


        $query = $this->createQueryBuilder('p')
            ->join('p.comments', 'com')
            ->addSelect('COUNT(com) as c')
            ->groupBy("p.title")
           ->having('c > 0')
          ->orderBy('c', 'desc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $query;


    }

    public function findByWord($word)
    {

        return $this
            ->createQueryBuilder('p')
            ->where('p.title LIKE :titles')
            ->setParameter('titles', '%' . $word . '%')
            ->getQuery()
            ->execute();


    }


}
