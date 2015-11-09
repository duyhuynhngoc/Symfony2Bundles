<?php
/**
 * Code Owner: CCIntegration Inc. S.P.I.D.E.R framework
 * Modified date: 11/5/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SystemBundle\Config;


class Entities {
    public static function getEntityPath($key)
    {
        $entities = array(
            "users" => "\\Gem\\SystemBundle\\Entity\\Users",
            "roles" => "\\Gem\\SystemBundle\\Entity\\Roles",
            "role_module" => "\\Gem\\SystemBundle\Entity\\Rolemodule",
            "role_menu" => "\\Gem\\SystemBundle\Entity\\Rolemenu",
            "modules" => "\\Gem\\SystemBundle\Entity\\Modules",
            "module_function" => "\\Gem\\SystemBundle\Entity\\Modulefunction",
            "menus" => "\\Gem\\SystemBundle\Entity\\Menus",
            "functions" => "\\Gem\\SystemBundle\Entity\\Functions",
            "function_action" => "\\Gem\\SystemBundle\Entity\\Functionaction",
            "config" => "\\Gem\\SystemBundle\Entity\\Configs",
            "actions" => "\\Gem\\SystemBundle\Entity\\Actions"
        );
        return $entities[$key];
    }
}