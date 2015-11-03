<?php

namespace Gem\DuyGenerationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GemDuyGenerationBundle:Default:index.html.twig', array('name' => $name));
    }
}
