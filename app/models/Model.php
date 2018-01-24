<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-20
 * Time: 22:38
 */

namespace models;

use classes\DataBase;

/**
 * Model - Base model.
 *
 * @package models
 */
class Model extends DataBase
{

	protected $name;
	protected $params;

	public function __construct()
	{
		$connection = $this->getConnection();
	}

	/**
	 * Get all from db.
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getAll($params)
	{
		$name = $this->name;
		$result = $this->get($name, $params);

		return $result;
	}

	public function getById($id)
	{
		$name = $this->name;
		$result = $this->dBgetById($name, $id);

		return $result;
	}

	/**
	 * Delete from table.
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function delete($id)
	{
		$name = $this->name;
		$result = $this->dbDelete($name, $id);

		return $result;
	}

	/**
	 * Save or update.
	 *
	 * @return bool
	 */
	public function save()
	{
		if(isset($this->id) && $this->id != 0) {
			$result = $this->dbUpdate();

			return $result;
		} elseif($this->id == 0) {
			$result = $this->dbSave();

			return $result;
		}
	}

}