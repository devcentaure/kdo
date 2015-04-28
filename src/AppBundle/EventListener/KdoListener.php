<?php

namespace AppBundle\EventListener;


use AppBundle\AppEvent;
use AppBundle\Event\KdoEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContext;

class KdoListener implements EventSubscriberInterface
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
            AppEvent::KdoAdd => 'kdoAdd',
            AppEvent::KdoUpdate => 'kdoUpdate',
            AppEvent::KdoDelete => 'kdoDelete',
            AppEvent::KdoCalculate => 'kdoCalculate'
        );
    }

    public function kdoAdd(KdoEvent $kdoEvent)
    {
        $this->em->persist($kdoEvent->getKdo());
        $this->em->flush();
        $this->kdoCalculate($kdoEvent);
    }

    public function kdoUpdate(KdoEvent $kdoEvent)
    {
        $kdoEvent->getKdo()->preUpload();
        $this->em->persist($kdoEvent->getKdo());
        $this->em->flush();
        $this->kdoCalculate($kdoEvent);
    }

    public function kdoDelete(KdoEvent $kdoEvent)
    {
        $this->em->remove($kdoEvent->getKdo());
        $this->em->flush();
        $this->kdoCalculate($kdoEvent);
    }

    public function kdoCalculate(KdoEvent $kdoEvent)
    {
        $entity = $kdoEvent->getKdo();

        $usersKdo = $this->em->getRepository('AppBundle:UserKdo')->findBy(array('kdo' => $entity));

        if ($usersKdo > 0) {
            $somme = 0;
            foreach ($usersKdo as $uk) {
                $somme += $uk->getUserShare();
            }

            $entity->setForecast($somme);
            $this->em->persist($kdoEvent->getKdo());
            $this->em->flush();
        }
    }
}