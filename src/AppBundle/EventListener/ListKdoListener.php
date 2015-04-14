<?php

namespace AppBundle\EventListener;


use AppBundle\AppEvent;
use AppBundle\Event\ListKdoEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ListKdoListener implements EventSubscriberInterface
{
    private $em;
    private $securityContext;

    public function __construct(
        EntityManager $em,
        SecurityContext $securityContext
    ) {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AppEvent::ListKdoAdd => 'listKdoAdd',
            AppEvent::ListKdoUpdate=> 'listKdoUpdate',
            AppEvent::ListKdoDelete => 'listKdoDelete'
        );
    }

    public function listKdoAdd(ListKdoEvent $listKdoEvent)
    {
        $this->em->persist($listKdoEvent->getListKdo());
        $this->em->flush();

    }

    public function listKdoUpdate(ListKdoEvent $listKdoEvent)
    {
        $this->em->persist($listKdoEvent->getListKdo());
        $this->em->flush();
    }

    public function listKdoDelete(ListKdoEvent $listKdoEvent)
    {
        $this->em->remove($listKdoEvent->getListKdo());
        $this->em->flush();

    }
}