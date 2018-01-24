<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-21
 * Time: 10:47
 */

namespace controllers;

use models\ProductModel;
use classes\Config;

/**
 * ProductsController - Controller for work with products.
 *
 * @package controllers
 */
class ProductsController extends Controller
{

	public $params;
	public $paginator;
	public $currentPage;

	/**
	 * Returned all products.
	 */
	public function allAction()
	{
		if($this->currentPage == null) {
			$this->currentPage = $this->get(isset($_GET['page'])
				? $_GET['page']
				: 1);
		}
		$offset = ($this->currentPage - 1) * Config::get('pages');
		$products = new ProductModel();
		$this->params = [
			'page'   => $this->currentPage,
			'limit'  => Config::get('pages'),
			'offset' => $offset,
		];
		$data = $products->getAll($this->params);
		$this->params['total'] = $data['total'];
		$this->paginator = $this->pagination($this->params);
		$answear = [
			'status'    => 'ok',
			'body'      => $data,
			'paginator' => $this->paginator,
		];
		echo json_encode($answear);
	}

	/**
	 * Delete product from table.
	 */
	public function deleteAction()
	{
		$id = $this->get($_GET['id']);
		$this->currentPage = $this->get($_GET['page']);
		$products = new ProductModel();
		$responce = $products->delete($id);

		if($responce) {
			$this->allAction();
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	/**
	 * Save new or update product.
	 */
	public function saveAction()
	{
		$id = $this->get($_GET['id']);
		$title = substr($this->get($_GET['title']), 0, 35);
		$price = floatval($this->get($_GET['price']));
		if(isset($_GET['page']) && $_GET['id'] != 0) {
			$this->currentPage = $this->get($_GET['page']);
		} else {
			$this->currentPage = 1;
		}
		$products = new ProductModel();
		$products->id = $id;
		$products->title = $title;
		$products->price = $price * 100;
		$responce = $products->save();
		if($responce) {
			$this->allAction();
		} else {
			echo json_encode(['status' => 'error']);
		}
	}
} 