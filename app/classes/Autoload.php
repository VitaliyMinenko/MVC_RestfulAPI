<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-18
 * Time: 23:19
 */

namespace classes;

/**
 * Class Autoload - Class for autoload all classes.
 *
 * @package classes
 */
class Autoload
{

	/**
	 * Method for autload.
	 *
	 * @param $class
	 */
	public function loadClass($class)
	{
		$file = 'app/' . $class . '.php';
		if(is_file($file)) {
			require_once($file);
		}
	}

} 