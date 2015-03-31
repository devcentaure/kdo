<?php

namespace AppBundle\Controller;

use ZIMZIM\ToolsBundle\Controller\MainController;
use Symfony\Component\HttpFoundation\Request;


/**
 * Category controller.
 *
 */
class HomeController extends MainController
{
    public function indexAction(){

        return $this->render(
            'AppBundle:Home:index.html.twig'
        );

    }

}