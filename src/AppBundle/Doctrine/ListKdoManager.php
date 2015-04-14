<?php

namespace AppBundle\Doctrine;

use ZIMZIM\ToolsBundle\Doctrine\Manager;

class ListKdoManager extends Manager
{
    public function getBySlug($slug)
    {
        return $this->getRepository()->findOneBy(array('slug' => $slug));
    }
}