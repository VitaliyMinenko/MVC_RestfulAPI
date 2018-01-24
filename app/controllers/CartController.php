<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 23.01.2018
 * Time: 10:15
 */

namespace controllers;

use classes\Config;
use models\ProductModel;

/**
 * Class CartController - Controller for car.
 *
 * @package controllers
 */
class CartController extends Controller
{
	/**
	 * Get information about products from cart.
	 */
	public function mainAction()
	{
		$responce = [
			'status' => 'ok',
			'data'   => $_SESSION['cart']['products'],
			'total'  => $_SESSION['cart']['total'],
		];
		echo json_encode($responce);
	}

	/**
	 * Add new product to cart.
	 */
	public function addAction()
	{
		if(count($_SESSION['cart']['products']) > Config::$config['max_in_cart'] - 1) {
			echo json_encode(['status' => 'error']);
		} else {
			$id = $this->get($_GET['id']);
			$products = new ProductModel();
			$responce = $products->getById($id);
			$product = [
				'id'       => $responce['id'],
				'title'    => $responce['title'],
				'price'    => $responce['price'],
				'currency' => $responce['currency'],
			];
			$_SESSION['cart']['products'][] = $product;
			$_SESSION['cart']['total'] = $_SESSION['cart']['total'] + $responce['price'];
			$responce = [
				'status' => 'ok',
				'data'   => $_SESSION['cart']['products'],
				'total'  => $_SESSION['cart']['total'],
			];
			echo json_encode($responce);
		}
	}

	public function totalAction()
	{
		$responce = [
			'status' => 'ok',
			'total'  => $_SESSION['cart']['total'],
		];
		echo json_encode($responce);
	}

	/**
	 * Delete product from cart.
	 */
	public function deleteAction()
	{
		$increment = $this->get($_GET['inc']);
		$product = $_SESSION['cart']['products'][$increment];
		unset($_SESSION['cart']['products'][$increment]);
		sort($_SESSION['cart']['products']);
		$_SESSION['cart']['total'] = $_SESSION['cart']['total'] - $product['price'];
		$this->mainAction();
	}

}