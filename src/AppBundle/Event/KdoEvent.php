<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class KdoEvent extends Event
{
    private $response;

    private $kdo;

    /**
     * @param mixed $listKdo
     */
    public function setKdo($kdo)
    {
        $this->kdo = $kdo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKdo()
    {
        return $this->kdo;
    }
}
