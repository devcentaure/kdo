<?php

namespace AppBundle\EventListener;


use AppBundle\AppEvent;
use AppBundle\Event\KdoEvent;
use AppBundle\Event\UserKdoEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContext;

class UserKdoListener implements EventSubscriberInterface
{
    private $em;
    private $securityContext;
    private $kdoEvent;
    private $dispatcher;

    public function __construct(
        EntityManager $em,
        SecurityContext $securityContext,
        $dispatcher,
        KdoEvent $kdo_event
    ) {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->dispatcher = $dispatcher;
        $this->kdoEvent = $kdo_event;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AppEvent::UserKdoAdd => 'userKdoAdd',
            AppEvent::UserKdoUpdate => 'userKdoUpdate',
            AppEvent::UserKdoDelete => 'userKdoDelete'
        );
    }

    public function userKdoAdd(UserKdoEvent $userKdoEvent)
    {
        $this->em->persist($userKdoEvent->getUserkdo());
        $this->em->flush();
        $this->calculateKdo($userKdoEvent);
    }

    public function userKdoUpdate(UserKdoEvent $userKdoEvent)
    {
        $this->em->persist($userKdoEvent->getUserkdo());
        $this->em->flush();
        $this->calculateKdo($userKdoEvent);
    }

    public function userKdoDelete(UserKdoEvent $userKdoEvent)
    {
        $this->em->remove($userKdoEvent->getUserkdo());
        $this->em->flush();
        $this->calculateKdo($userKdoEvent);
    }

    private function calculateKdo(UserKdoEvent $userKdoEvent)
    {
        $this->kdoEvent->setKdo($userKdoEvent->getUserkdo()->getKdo());
        $this->dispatcher->dispatch(AppEvent::KdoCalculate, $this->kdoEvent);

    }
}
