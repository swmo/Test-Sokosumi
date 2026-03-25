<?php

namespace App\Repository;

use App\Entity\Registration;
use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Registration>
 */
class RegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registration::class);
    }

    public function findByUserAndEvent(User $user, Event $event): ?Registration
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->andWhere('r.event = :event')
            ->setParameter('user', $user)
            ->setParameter('event', $event)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
