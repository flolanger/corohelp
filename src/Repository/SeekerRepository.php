<?php

namespace Corohelp\Repository;

use Corohelp\Entity\Seeker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class SeekerRepository
 */
class SeekerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seeker::class);
    }
}
