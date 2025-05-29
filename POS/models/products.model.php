<?php

require_once 'connection.php';

class ProductsModel
{
	private static $conn;

	// Ensure connection is initialized
	private static function ensureConnection()
	{
		if (!self::$conn) {
			// connection() should return a PDO instance
			self::$conn = (new Connection())->connection();
			if (!self::$conn) {
				throw new Exception("Database connection not initialized.");
			}
		}
	}

	public static function init($dbConnection)
	{
		self::$conn = $dbConnection;
	}

	/*=============================================
    SHOWING PRODUCTS
    =============================================*/

	static public function mdlShowProducts($table, $item, $value, $order)
	{
		self::ensureConnection();

		if ($item != null) {

			$stmt = self::$conn->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {
			// Fix: Only add ORDER BY if $order is provided and valid, otherwise default to id
			$orderBy = (!empty($order)) ? $order : 'id';
			$stmt = self::$conn->prepare("SELECT * FROM $table ORDER BY $orderBy DESC");

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
    ADDING PRODUCT
    =============================================*/
	static public function mdlAddProduct($table, $data)
	{
		self::ensureConnection();

		// Ensure 'sales' is always set to 0 if not provided
		if (!isset($data["sales"])) {
			$data["sales"] = 0;
		}

		$stmt = self::$conn->prepare("INSERT INTO $table(idCategory, code, description, image, stock, buyingPrice, sellingPrice, sales) VALUES (:idCategory, :code, :description, :image, :stock, :buyingPrice, :sellingPrice, :sales)");

		$stmt->bindParam(":idCategory", $data["idCategory"], PDO::PARAM_INT);
		$stmt->bindParam(":code", $data["code"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
		$stmt->bindParam(":image", $data["image"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $data["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":buyingPrice", $data["buyingPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":sellingPrice", $data["sellingPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":sales", $data["sales"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
    EDITING PRODUCT
    =============================================*/
	static public function mdlEditProduct($table, $data)
	{
		self::ensureConnection();

		$stmt = self::$conn->prepare("UPDATE $table SET idCategory = :idCategory, description = :description, image = :image, stock = :stock, buyingPrice = :buyingPrice, sellingPrice = :sellingPrice WHERE code = :code");

		$stmt->bindParam(":idCategory", $data["idCategory"], PDO::PARAM_INT);
		$stmt->bindParam(":code", $data["code"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
		$stmt->bindParam(":image", $data["image"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $data["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":buyingPrice", $data["buyingPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":sellingPrice", $data["sellingPrice"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
    DELETING PRODUCT
    =============================================*/

	static public function mdlDeleteProduct($table, $data)
	{
		self::ensureConnection();

		$stmt = self::$conn->prepare("DELETE FROM $table WHERE id = :id");

		$stmt->bindParam(":id", $data, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
    UPDATE PRODUCT
    =============================================*/

	static public function mdlUpdateProduct($table, $item1, $value1, $value)
	{
		self::ensureConnection();

		$stmt = self::$conn->prepare("UPDATE $table SET $item1 = :$item1 WHERE id = :id");

		$stmt->bindParam(":" . $item1, $value1, PDO::PARAM_STR);
		$stmt->bindParam(":id", $value, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
    SHOW ADDING OF THE SALES
    =============================================*/

	static public function mdlShowAddingOfTheSales($table)
	{
		self::ensureConnection();

		$stmt = self::$conn->prepare("SELECT SUM(sales) as total FROM $table");

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;
	}
}
