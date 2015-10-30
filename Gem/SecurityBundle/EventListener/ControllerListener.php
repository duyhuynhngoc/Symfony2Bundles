<?php
/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 10/29/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SecurityBundle\EventListener;


use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerListener {
    public function onKernelController(FilterControllerEvent $event)
    {
        try{
            $request = $event->getRequest();
            $jsonContent = $request->getContent();


            $jsonDecode = json_decode($jsonContent, true);

            $apikey = null;

            if(isset($jsonDecode['apikey']))
                $apikey = $jsonDecode['apikey'];
            else
                $apikey = $request->query->get('apikey');


        }catch (\Exception $e)
        {

        }
    }
}