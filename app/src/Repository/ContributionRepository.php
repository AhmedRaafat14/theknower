<?php

namespace App\Repository;

use App\Entity\Contribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contribution[]    findAll()
 * @method Contribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contribution::class);
    }

    public function save(Contribution $contribution): void
    {
        $this->getEntityManager()->persist($contribution);
        $this->getEntityManager()->flush();
    }

    public function remove(Contribution $contribution): void
    {
        $this->getEntityManager()->remove($contribution);
        $this->getEntityManager()->flush();
    }
}
