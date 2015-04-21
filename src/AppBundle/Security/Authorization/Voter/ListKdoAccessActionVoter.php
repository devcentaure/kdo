<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;


class ListKdoAccessActionVoter implements VoterInterface
{
    private $em;
    private $voter;

    public function __construct(EntityManager $em, RoleHierarchyVoter $voter)
    {
        $this->em = $em;
        $this->voter = $voter;
    }

    const ACCESS_DELETE = 'LISTKDO_DELETE';
    const ACCESS_UPDATE = 'LISTKDO_UPDATE';
    const ACCESS_VIEW = 'LISTKDO_VIEW';

    public function supportsAttribute($action)
    {
        return ($action === self::ACCESS_UPDATE || $action === self::ACCESS_VIEW || $action === self::ACCESS_DELETE);
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Entity\ListKdo';

        return ($class === $supportedClass || $class === 'Proxies\\__CG__\\' . $supportedClass);

    }

    public function vote(TokenInterface $token, $entity, array $attributes)
    {
        if (!$this->supportsClass(get_class($entity))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        if (count($attributes) !== 1) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        $action = $attributes[0];
        if (!$this->supportsAttribute($action)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        if ($this->voter->vote($token, null, array('ROLE_ADMIN')) === VoterInterface::ACCESS_GRANTED) {
            return VoterInterface::ACCESS_GRANTED;
        }

        if ($this->voter->vote($token, null, array('ROLE_USER')) === VoterInterface::ACCESS_GRANTED) {

            if($entity->getUser() === $user){
                return VoterInterface::ACCESS_GRANTED;
            }

            if ($action === self::ACCESS_VIEW) {
                $access = $this->em->getRepository('AppBundle:UserListKdo')->getAccessUser($entity, $user);

                if ($access !== null) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;

    }
}