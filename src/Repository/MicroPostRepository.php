<?php

namespace App\Repository;

use App\Entity\MicroPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MicroPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroPost[]    findAll()
 * @method MicroPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MicroPost::class);
    }

    public function findAllDescending()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

    //-- EXAMPLE OF QUERY BUILDER
    public function findAllByUsers($userIds)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->select('p')
            ->innerJoin(
                'App\Entity\User',
                'u',
                'WITH',
                'p.user = u.id'
            )
            ->where('u.id IN (:following)')
            ->setParameter(
                'following',
                $userIds
            )
            ->orderBy('p.time', 'DESC')
            ->getQuery()
            ->getResult();
    }


    //-- EXAMPLE OF DQL QUERY
    public function findAllGreaterThanId($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
        FROM App\Entity\MicroPost p
        WHERE p.id > :id
        ORDER BY p.id DESC'
        )->setParameter('id', $id);

        // returns an array of Product objects
        return $query->execute();
    }

    //-- EXAMPLE OF PLAIN SQL QUERY
    public function findAllGreaterThanIdSQL($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM micro_post p
        WHERE p.id > :id
        ORDER BY p.id DESC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }


    // /**
    //  * @return MicroPost[] Returns an array of MicroPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MicroPost
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
