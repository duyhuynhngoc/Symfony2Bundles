<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 11/5/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Entity;



class BaseEntity {
    public function __construct($data = array())
    {

    }
    public function owner()
    {

    }

    public function toAssocArray($arrAttributes = array())
    {
        $data = array();
        $properties = (array)$this;
        $attr = count($arrAttributes) > 0;
        foreach ($properties as $key => $value) {
            $key = trim(substr($key, 2));
            if($attr && !in_array($key, $arrAttributes))
                continue;
            $data[$key] = $value;

        }
        return $data;
    }

}