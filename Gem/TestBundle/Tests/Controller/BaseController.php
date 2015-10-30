<?php

namespace Gem\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseController extends WebTestCase
{
    protected function post($uri, $parameter = array() ,$data = array())
    {
        $headers = array('CONTENT_TYPE' => 'application/json');
        $content = json_encode($data);
        $client = static::createClient();
        $client->request('POST', $uri, $parameter, array(), $headers, $content);
        return $client->getResponse();
    }

    protected function get($uri)
    {
        $headers = array('CONTENT_TYPE' => 'application/json');
        $client = static::createClient();
        $client->request('GET', $uri, array(), array(), $headers);

        return $client->getResponse();
    }
}
