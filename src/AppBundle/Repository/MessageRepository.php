<?php

namespace AppBundle\Repository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Return Messages from database from last 24 hours
     *
     * @param int $limit limit of messages
     *
     * @return array array of Messages Entity
     */
    public function getMessagesFromLastDay(int $limit)
    {
        $date = new \DateTime('now');
        $date->modify( '-1 day' );

        return $this->createQueryBuilder('m')
                ->where('m.date >= :date')
                ->orderBy('m.date', 'DESC')
                ->setMaxResults($limit)
                ->setParameter('date', $date)
                ->getQuery()->getResult();

    }

    public function getMessagesFromLastId(int $lastId, int $limit)
    {
        return $this->createQueryBuilder('m')
            ->where('m.id > :id')
            ->orderBy('m.date', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('id', $lastId)
            ->getQuery()->getResult();
    }
}
