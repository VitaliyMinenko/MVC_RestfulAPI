<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-18
 * Time: 23:11
 */

use \classes\Autoload;
use  \classes\Router;

/**
 * Require autoload class and initialization.
 */
require 'app/classes/Autoload.php';
$autoLoader = new Autoload();
spl_autoload_register([
	$autoLoader,
	'loadClass',
]);

/**
 * Start new session if not exist.
 */
session_start();

/**
 * Initialisation new cart.
 */
if(!isset($_SESSION['cart'])) {
	$_SESSION['cart']['products'] = [];
	$_SESSION['cart']['total'] = 0;
}

/**
 * Initialization of router.
 */
$router = new Router();
$router->start();


