<?php

namespace Billeterie\BilleterieBundle\Repository;


class TicketsRepository extends \Doctrine\ORM\EntityRepository
{
   const BILLET_MAX = 1000;

    public function countTicket()
    {
        $qb = $this->createQueryBuilder('tickets');
        $qb->select('count(tickets.id)')
            ->join('tickets.reservation', 'r')
            ->where('SUBSTRING(r.dateDeVisite, 1, 10) = :today')
            ->setParameter('today', date("Y-m-d"));

        $count = intval($qb->getQuery()->getSingleScalarResult());
        if ($count >= self::BILLET_MAX) {
            return false;
        }
        return true;
    }
}