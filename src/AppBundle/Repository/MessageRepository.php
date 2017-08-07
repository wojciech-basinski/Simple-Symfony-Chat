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
    public function getMessagesFromLastDay(int $limit, int $channel)
    {
        $date = new \DateTime('now');
        $date->modify( '-1 day' );

        return $this->createQueryBuilder('m')
                ->where('m.date >= :date')
                ->andWhere('m.channel = :channel')
                ->orderBy('m.date', 'DESC')
                ->setParameter('date', $date)
                ->setParameter('channel', $channel)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }

    public function getMessagesFromLastId(int $lastId, int $limit, int $channel)
    {
        return $this->createQueryBuilder('m')
                ->where('m.id > :id')
                ->andWhere('m.channel = :channel')
                ->orderBy('m.id', 'ASC')
                ->setParameter('id', $lastId)
                ->setParameter('channel', $channel)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }
}
