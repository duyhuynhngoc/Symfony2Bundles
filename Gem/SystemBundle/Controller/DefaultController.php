<?php

namespace Gem\SystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GemSystemBundle:Default:index.html.twig', array('name' => $name));
    }
}
