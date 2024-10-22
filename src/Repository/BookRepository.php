<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
//     public function findBooksBetweenDates(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
// {
//     return $this->createQueryBuilder('b')
//         ->andWhere('b.publicationDate BETWEEN :startDate AND :endDate')
//         ->setParameter('startDate', $startDate)
//         ->setParameter('endDate', $endDate)
//         ->orderBy('b.publicationDate', 'ASC') // Trier par date de publication
//         ->getQuery()
//         ->getResult();
// }
public function findBooksBetweenDates(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
{
    $dql = "SELECT b FROM App\Entity\Book b
            WHERE b.publicationDate BETWEEN :startDate AND :endDate
            ORDER BY b.publicationDate ASC";

    return $this->getEntityManager()->createQuery($dql)
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getResult();
}





//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
