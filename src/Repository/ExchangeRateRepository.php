<?php

namespace App\Repository;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRate[]    findAll()
 * @method ExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    /**
     * @param string $source
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return ExchangeRate|null
     */
    public function findSourceCourse(string $source, string $currencyFrom, string $currencyTo)
    {
        $maxCacheLiveDate = new \DateTime('now');
        $maxCacheLiveDate->modify('-3 minute');
        return $this->createQueryBuilder('e')
            ->andWhere('e.source = :source')
            ->andWhere('e.currencyCodeFrom = :currencyFrom')
            ->andWhere('e.currencyCodeTo = :currencyTo')
            ->andWhere('e.createdAt > :maxCacheLiveDate')
            ->setParameters([
                'source' => $source,
                'currencyFrom' => $currencyFrom,
                'currencyTo' => $currencyTo,
                'maxCacheLiveDate' => $maxCacheLiveDate
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*
    public function findOneBySomeField($value): ?ExchangeRate
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
