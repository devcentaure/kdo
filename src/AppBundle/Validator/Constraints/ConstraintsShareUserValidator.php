<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class ConstraintsShareUserValidator extends ConstraintValidator
{
    private $em;
    private $securityContext;

    public function __construct(EntityManager $em, SecurityContext $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function validate($class, Constraint $constraint)
    {
        $valueKdo = $class->getKdo()->getQuantity() * $class->getKdo()->getPrice();

        $usersKdo = $this->em->getRepository('AppBundle:UserKdo')->findBy(array('kdo' => $class->getKdo()));

        $somme = $sommeDif = 0;
        foreach ($usersKdo as $uk) {
            $somme += $uk->getUserShare();
        }
        $sommeDif = $valueKdo - $somme;

        if ($class->getAuction()) {

            if ($valueKdo < $class->getUserShare()) {
                $this->context->addViolation($constraint->messageMax);
            }

            if (($sommeDif < $class->getUserShare())) {
                $this->context->addViolation($constraint->messageValue, array('%value%' => $sommeDif));
            }

        } else {
            $class->setUserShare($sommeDif);
        }
    }
}
