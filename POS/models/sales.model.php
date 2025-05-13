<?php

require_once 'connection.php';

class ModelSales
{
	private static $db;

	public static function init(Connection $connection)
	{
		self::$db = $connection->connect();
	}

	static public function mdlShowSales($table, $item, $value)
	{
		if (!$item) {
			$stmt = self::$db->prepare("SELECT * FROM $table ORDER BY id ASC");
			$stmt->execute();
			return $stmt->fetchAll();
		} else {
			$stmt = self::$db->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id ASC");
			$stmt->bindParam(":$item", $value, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		}
	}

	static public function mdlAddSale($table, $data)
	{
		$stmt = self::$db->prepare("INSERT INTO $table(code, idCustomer, idSeller, products, tax, netPrice, totalPrice, paymentMethod)
			VALUES (:code, :idCustomer, :idSeller, :products, :tax, :netPrice, :totalPrice, :paymentMethod)");

		$stmt->bindParam(":code", $data["code"]);
		$stmt->bindParam(":idCustomer", $data["idCustomer"]);
		$stmt->bindParam(":idSeller", $data["idSeller"]);
		$stmt->bindParam(":products", $data["products"]);
		$stmt->bindParam(":tax", $data["tax"]);
		$stmt->bindParam(":netPrice", $data["netPrice"]);
		$stmt->bindParam(":totalPrice", $data["totalPrice"]);
		$stmt->bindParam(":paymentMethod", $data["paymentMethod"]);

		return $stmt->execute() ? "ok" : "error";
	}

	static public function mdlEditSale($table, $data)
	{
		$stmt = self::$db->prepare("UPDATE $table SET idCustomer = :idCustomer, idSeller = :idSeller, products = :products, tax = :tax, netPrice = :netPrice, totalPrice = :totalPrice, paymentMethod = :paymentMethod WHERE code = :code");

		$stmt->bindParam(":code", $data["code"]);
		$stmt->bindParam(":idCustomer", $data["idCustomer"]);
		$stmt->bindParam(":idSeller", $data["idSeller"]);
		$stmt->bindParam(":products", $data["products"]);
		$stmt->bindParam(":tax", $data["tax"]);
		$stmt->bindParam(":netPrice", $data["netPrice"]);
		$stmt->bindParam(":totalPrice", $data["totalPrice"]);
		$stmt->bindParam(":paymentMethod", $data["paymentMethod"]);

		return $stmt->execute() ? "ok" : "error";
	}

	static public function mdlDeleteSale($table, $id)
	{
		$stmt = self::$db->prepare("DELETE FROM $table WHERE id = :id");
		$stmt->bindParam(":id", $id);
		return $stmt->execute() ? "ok" : "error";
	}

	static public function mdlSalesDatesRange($table, $initialDate, $finalDate)
	{
		if ($initialDate == null) {
			$stmt = self::$db->prepare("SELECT * FROM $table ORDER BY id ASC");
		} else if ($initialDate == $finalDate) {
			$stmt = self::$db->prepare("SELECT * FROM $table WHERE saledate LIKE :saledate");
			$stmt->bindParam(":saledate", $finalDate);
		} else {
			$stmt = self::$db->prepare("SELECT * FROM $table WHERE saledate BETWEEN :start AND :end");
			$stmt->bindParam(":start", $initialDate);
			$stmt->bindParam(":end", $finalDate);
		}

		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function mdlAddingTotalSales($table)
	{
		$stmt = self::$db->prepare("SELECT SUM(netPrice) as total FROM $table");
		$stmt->execute();
		return $stmt->fetch();
	}
}

// Initialize connection
try {
	$dbConnection = new Connection();
	ModelSales::init($dbConnection);
} catch (Exception $e) {
	die("DB Error: " . $e->getMessage());
}
