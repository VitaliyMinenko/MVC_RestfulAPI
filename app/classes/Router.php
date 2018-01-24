<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-20
 * Time: 14:33
 */

namespace classes;

/**
 * Class Router - Set all available routs.
 *
 * @package classes
 */
class Router
{

	/**
	 * Base method fpr route.
	 */
	public function start()
	{

		require_once('app/controllers/MainController.php');
		$route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		$routing = [
			//  Routs for application.
			'/'                    => [
				'controller' => 'Main',
				'action'     => 'index',
			],
			// Routs for api.
			'/api/products'        => [
				'controller' => 'Products',
				'action'     => 'all',
			],
			'/api/products/delete' => [
				'controller' => 'Products',
				'action'     => 'delete',
			],
			'/api/products/save'   => [
				'controller' => 'Products',
				'action'     => 'save',
			],
			'/api/cart/main'       => [
				'controller' => 'Cart',
				'action'     => 'main',
			],
			'/api/cart/add'        => [
				'controller' => 'Cart',
				'action'     => 'add',
			],
			'/api/cart/delete'     => [
				'controller' => 'Cart',
				'action'     => 'delete',
			],
			'/api/cart/total'      => [
				'controller' => 'Cart',
				'action'     => 'total',
			],
		];
		if(isset($routing[$route])) {
			$controller = '\\controllers\\' . $routing[$route]['controller'] . 'Controller';
			$objectController = new $controller;
			$action = $routing[$route]['action'] . 'Action';
			$objectController->$action();
		} else {
			echo 'Nothing to found';
		}
	}

} 