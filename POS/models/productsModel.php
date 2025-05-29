<?php

require_once 'connection.php';


class productsModel
{
	static private $conn;

	public static function init($dbConnection)
	{
		self::$conn = $dbConnection;
	}
	/*=============================================
	SHOWING PRODUCTS
	=============================================*/

	static public function mdlShowProducts($table, $item, $value)
	{

		if ($item != null) {

			$stmt = self::$conn->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {
			$stmt = self::$conn->prepare("SELECT * FROM $table ORDER BY id DESC");

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

		$stmt = self::$conn->prepare("INSERT INTO $table(idCategory, code, description, image, stock, buyingPrice, sellingPrice) VALUES (:idCategory, :code, :description, :image, :stock, :buyingPrice, :sellingPrice)");

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
	EDITING PRODUCT
	=============================================*/
	static public function mdlEditProduct($table, $data)
	{

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
}
