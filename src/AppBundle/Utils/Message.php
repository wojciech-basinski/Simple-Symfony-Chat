<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Message
{
    const MAX_MESSAGES = 32;
    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getMessagesInIndex()
    {
        $messages = $this->em->getRepository('AppBundle:Message')
            ->getMessagesFromLastDay(self::MAX_MESSAGES);

        $lastId = end($messages);
        if ($lastId) {
            $this->session->set('lastid', $lastId->getId());
        } else {
            $this->session->set('lastid', 0);
        }

        return  $this->checkIfMessagesCanBeDisplayed($messages);
    }

    public function getMessagesFromLastId(int $lastId)
    {
        $messages = $this->em->getRepository('AppBundle:Message')
            ->getMessagesFromLastId($lastId, self::MAX_MESSAGES);

        return  $this->checkIfMessagesCanBeDisplayed($messages);
    }

    public function addMessageToDatabase($user, int $channel, string $text):bool
    {
        $message = new \AppBundle\Entity\Message();
        $message->setUserInfo($user);
        $message->setChannel($channel);
        $message->setText($text);
        $message->setDate(new \DateTime());
        $this->em->getRepository('AppBundle:Message');
        try {
            $this->em->persist($message);
            $this->em->flush();
        } catch(\Throwable $e) {
            return 0;
        }
        return 1;
    }

    private function checkIfMessagesCanBeDisplayed(array $messages)
    {

        return $messages;
    }
}