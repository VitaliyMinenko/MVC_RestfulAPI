<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-20
 * Time: 22:57
 */

namespace models;

/**
 * ProductModel - Model for products.
 *
 * @package models
 */
class ProductModel extends Model
{
	/**
	 * Set table name.
	 */
	protected $name = 'products';

	/**
	 * Set properties.
	 */
	public $id;
	public $title;
	public $price;
	public $currency = 'USD';
} 