<?php

namespace Gem\TestBundle\Tests\Controller;
use Symfony\Component\HttpFoundation\Response;


class SecurityControllerTest extends BaseController
{
    public function testControllerListener()
    {
        ScriptHa
        $response = $this->post("/test/security/controller", array('apikey' => "ahaha"), array('apikey' => "keys"));
       // $this->assertContains("result: ", "ajsjsk");
        $testedVar = array("ahaha");


        $this->assertContains("200", array($response->getStatusCode()));

    }
}
