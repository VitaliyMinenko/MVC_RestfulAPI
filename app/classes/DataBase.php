<?php
/**
 * Created by PhpStorm.
 * User: Vitalii
 * Date: 2018-01-20
 * Time: 22:21
 */

namespace classes;

use PDO;

/**
 * Class DataBase - Class for communicate with db.
 *
 * @package classes
 */
class DataBase
{

	public static $_instance;
	private static $DB_HOST;
	private static $DB_NAME;
	private static $DB_USER;
	private static $DB_PASS;

	/**
	 * DataBase constructor.
	 */
	private function __construct()
	{

		self::$DB_HOST = Config::get('host');
		self::$DB_NAME = Config::get('db_name');
		self::$DB_USER = Config::get('user_name');
		self::$DB_PASS = Config::get('password');

		try {
			self::$_instance = new PDO(
				'mysql:host=' . self::$DB_HOST . ';dbname=' . self::$DB_NAME,
				self::$DB_USER,
				self::$DB_PASS,
				[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
			);
		} catch(PDOException $e) {
			die('Connection error: ' . $e->getMessage());
		}
	}

	/**
	 * Close another access.
	 */
	private function __clone()
	{
	}

	/**
	 * Close another access.
	 */
	private function __wakeup()
	{
	}

	/**
	 * Getter for db connection.
	 *
	 * @return DataBase|PDO
	 */
	public static function getConnection()
	{
		if(self::$_instance != null) {
			return self::$_instance;
		}

		return new self;
	}

	/**
	 * Get all from table.
	 *
	 * @param $tableName
	 * @param $params
	 *
	 * @return array
	 */
	public function get($tableName, $params)
	{
		try {
			$limit = intval(isset($params['limit'])
				? $params['limit']
				: 0);
			$offset = intval(isset($params['offset'])
				? $params['offset']
				: 0);
			$total = $this->totalElements($tableName);
			$connection = self::getConnection();
			$query = "SELECT * FROM " . $tableName . " ORDER BY id DESC LIMIT ? OFFSET ? ";
			$stmt = $connection->prepare($query);
			$stmt->bindValue(1, $limit, PDO::PARAM_INT);
			$stmt->bindValue(2, $offset, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetchAll();
			$answear = [
				'data'   => $data,
				'limit'  => $limit,
				'offset' => $offset,
				'total'  => $total,
			];
		} catch(PDOException $Exception) {

		}

		return $answear;
	}

	/**
	 * Get element by id.
	 *
	 * @param $tableName
	 * @param $id
	 *
	 * @return array
	 */
	public function dBgetById($tableName, $id)
	{
		try {
			$connection = self::getConnection();
			$query = "SELECT * FROM " . $tableName . " WHERE id = ?";
			$stmt = $connection->prepare($query);
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$data = $stmt->fetchAll();
		} catch(PDOException $Exception) {

		}

		return $data[0];
	}

	/**
	 *
	 * Counter elemts in db.
	 *
	 * @param $tableName
	 *
	 * @return int
	 */
	private function totalElements($tableName)
	{
		try {
			$connection = self::getConnection();
			$query = "SELECT COUNT(*) FROM " . $tableName;
			$stmt = $connection->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
		} catch(PDOException $Exception) {

		}

		return intval(isset($data[0][0])
			? $data[0][0]
			: 0);
	}

	/**
	 * Delete row from table.
	 *
	 * @param $tableName
	 * @param $id
	 *
	 * @return bool
	 */
	public function dbDelete($tableName, $id)
	{
		try {
			$id = intval($id);
			$connection = self::getConnection();
			$query = "DELETE FROM " . $tableName . " WHERE id = ?";
			$stmt = $connection->prepare($query);
			$stmt->bindValue(1, $id, PDO::PARAM_INT);
			$data = $stmt->execute();
		} catch(PDOException $Exception) {

		}

		return $data;
	}

	/**
	 * Update row in table.
	 *
	 * @return bool
	 */
	public function dbUpdate()
	{
		try {
			$id = $this->id;
			$tableName = $this->name;
			$price = $this->price;
			$title = $this->title;
			$connection = self::getConnection();
			$query = "UPDATE " . $tableName . " SET price = ?, title = ? WHERE id = ?";
			$stmt = $connection->prepare($query);
			$stmt->bindValue(1, $price, PDO::PARAM_STR);
			$stmt->bindValue(2, $title, PDO::PARAM_INT);
			$stmt->bindValue(3, $id, PDO::PARAM_INT);
			$data = $stmt->execute();
		} catch(PDOException $Exception) {

		}

		return $data;
	}

	/**
	 * Insert new item in db.
	 *
	 * @return bool
	 */
	public function dbSave()
	{
		try {
			$tableName = $this->name;
			$price = $this->price;
			$title = $this->title;
			$currency = $this->currency;
			$connection = self::getConnection();
			$query = "INSERT INTO " . $tableName . " (price,title,currency) VALUES (?,?,?)";
			$stmt = $connection->prepare($query);
			$stmt->bindValue(1, $price, PDO::PARAM_STR);
			$stmt->bindValue(2, $title, PDO::PARAM_INT);
			$stmt->bindValue(3, $currency, PDO::PARAM_STR);
			$data = $stmt->execute();
		} catch(PDOException $Exception) {

		}

		return $data;
	}

}