<?php

namespace Ccicore\ConfigurationBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class ConfigurationController
{
    public function buildConfigAction()
    {
        $resp = new \stdClass();
        try{
            $params = $this->getRequestParams();

            $keylist = array();
            if(isset($params['configs'])){
                $keylist = $params['configs'];
            }

            $cls = $this->getBizClass();
            $data = $cls::buildConfiguration($keylist);

            $resp->Data = array('rows' => $data);
            $resp->Success = true;

        }catch (\Exception $e){
            $resp->Success = false;
            $resp->Data = array("Error" => array("key" => "system", "msg" => $e->getMessage()));
        }

        return new Response(json_encode($resp));
    }

    public function saveConfigAction()
    {
        $resp = new \stdClass();

        try{
            $params = $this->getRequestParams();
            if(!isset($params['data'])){
                throw new \Exception("Invalid posted data.");
            }
            $data = $params['data'];
            if(is_string($data)){
                $data = json_decode($data, true);
            }
            $cls = $this->getBizClass();
            $cls::saveConfig($data);

            $resp->Success = true;
            $resp->Data = null;

        }catch (\Exception $e){
            $resp->Success = false;
            $resp->Data = array("Error" => array("key" => "system", "msg" => $e->getMessage()));
        }

        return new Response(json_encode($resp));
    }

    public function getBizClass()
    {
        // TODO: Implement getBizClass() method.
        return "\Gem\ConfigurationBundle\Biz\ConfigurationBiz";
    }
}
