<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 23.01.2018
 * Time: 10:02
 */

namespace classes;

/**
 * Class Config - Get config.
 *
 * @package classes
 */
class Config
{
	/**
	 * Init config array.
	 *
	 * @var array
	 */
	public static $config = [
		//Db config
		'host'        => '127.0.0.1',
		'port'        => '22',
		'user_name'   => 'root',
		'db_name'     => 'shop',
		'password'    => '',

		//Application Config
		'title'       => 'My best shop',
		'pages'       => 3,
		'max_in_cart' => 3,
	];

	/**
	 * Getter of config.
	 */
	public static function get($configName)
	{
		return self::$config[$configName];
	}

}