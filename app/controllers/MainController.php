<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-18
 * Time: 23:28
 */

namespace controllers;

/**
 * MainController - Controller for view main page.
 *
 * @package controllers
 */
class MainController extends Controller
{
	/**
	 * Action for main page.
	 */
	public function indexAction()
	{
		$this->render('shop');
	}

} 