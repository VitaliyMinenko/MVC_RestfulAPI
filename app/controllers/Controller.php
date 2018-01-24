<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-20
 * Time: 19:01
 */

namespace controllers;

/**
 * Controller - Base controoler for all controllers.
 *
 * @package controllers
 */
class Controller
{

	/**
	 * Method for rendering view.
	 *
	 * @param      $tamplate
	 * @param null $args
	 */
	protected function render($tamplate, $args = null)
	{
		$tamplate = $tamplate;
		$args = $args;
		require_once('view/main.php');
	}

	protected function get($param)
	{
		$param = isset($param)
			? $param
			: '';
		$str = $param;
		$str = trim($str);
		$str = stripslashes($str);
		$str = htmlspecialchars($str);

		return $str;
	}

	protected function pagination($params)
	{
		if($params['page'] == 0) {
			$params['page'] = 1;
		}
		if($params['limit'] != 0) {
			$countPages = ceil($params['total'] / $params['limit']);
			$currentPage = $params['page'];
		} else {
			$countPages = 0;
			$currentPage = $params['page'];
		}

		return [
			'count_pages'  => $countPages,
			'current_page' => $currentPage,
		];
	}

}