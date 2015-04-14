<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ListKdoEvent extends Event
{
    private $response;

    private $listKdo;

    /**
     * @param mixed $listKdo
     */
    public function setListKdo($listKdo)
    {
        $this->listKdo = $listKdo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getListKdo()
    {
        return $this->listKdo;
    }



} 