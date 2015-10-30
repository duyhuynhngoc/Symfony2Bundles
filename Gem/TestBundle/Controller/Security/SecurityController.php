<?php

namespace Gem\TestBundle\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    public function controllerTestAction()
    {
        return new Response(json_encode(array("apikey"=>"ahaha")));
    }
}
