<?php
namespace Gem\SecurityBundle\Resources;

class AuthorizationData {

	protected static $data = array(
		'9-1-2'=>true,
		'9-1-3'=>true,
	);

	public static function checkAuthorize($key)
	{
		if (!isset(static::$data[$key]))
			return array();
		return static::$data[$key];
	}
}