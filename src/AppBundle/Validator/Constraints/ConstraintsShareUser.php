<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class ConstraintsShareUser extends Constraint
{
    public $messageMax = 'entity.userkdo.shareuser_max';
    public $messageValue = 'entity.userkdo.shareuser_value';

    public $classname = false;


    public function validatedBy()
    {
        return 'app_constraints_share_user_validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
