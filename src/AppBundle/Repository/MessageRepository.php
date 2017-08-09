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

    public function getMessagesFromLastIdAfterChangingChannel(int $limit, int $channel)
    {
        $date = new \DateTime('now');
        $date->modify( '-1 day' );

        return $this->createQueryBuilder('m')
            ->andWhere('m.date >= :date')
            ->andWhere('m.channel = :channel')
            ->orderBy('m.id', 'ASC')
            ->setParameter('channel', $channel)
            ->setParameter('date', $date)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getMessagesBetweenIds(int $idFirst, int $idSecond, int $channel)
    {
        return $this->createQueryBuilder('m')
            ->where('m.id BETWEEN :id1 AND :id2')
            ->andWhere('m.channel = :channel')
            ->orderBy('m.id', 'ASC')
            ->setParameter('id1', $idFirst)
            ->setParameter('id2', $idSecond)
            ->setParameter('channel', $channel)
            ->getQuery()
            ->getResult();
    }

    public function getIdFromLastMessage()
    {
        $message =  $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        if ($message) {
            return $message[0]->getId();
        } else {
            return 0;
        }
    }
}
