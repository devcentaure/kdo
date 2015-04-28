<?php

namespace AppBundle\Event;

use AppBundle\Entity\UserKdo;
use Symfony\Component\EventDispatcher\Event;

class UserKdoEvent extends Event
{
    private $response;

   private $userkdo;

    /**
     * @param mixed $userkdo
     */
    public function setUserkdo(UserKdo $userkdo)
    {
        $this->userkdo = $userkdo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserkdo()
    {
        return $this->userkdo;
    }
}
