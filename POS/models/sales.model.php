<?php

require_once 'connection.php';


class ModelSales
{
	// Declare the static property
    private static $conn;

    // Static method to initialize the connection
    public static function init($dbConnection) {
        self::$conn = $dbConnection;
    }
	/*=============================================
	SHOWING SALES
	=============================================*/


	static public function mdlShowSales($table, $item, $value)
	{

		if ($item != null) {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id ASC");

			$stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	REGISTERING SALE
	=============================================*/

	static public function mdlAddSale($table, $data)
	{

		$stmt = self::$conn->connect()->prepare("INSERT INTO $table(code, idCustomer, idSeller, products, tax, netPrice, totalPrice, paymentMethod) VALUES (:code, :idCustomer, :idSeller, :products, :tax, :netPrice, :totalPrice, :paymentMethod)");

		$stmt->bindParam(":code", $data["code"], PDO::PARAM_INT);
		$stmt->bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
		$stmt->bindParam(":idSeller", $data["idSeller"], PDO::PARAM_INT);
		$stmt->bindParam(":products", $data["products"], PDO::PARAM_STR);
		$stmt->bindParam(":tax", $data["tax"], PDO::PARAM_STR);
		$stmt->bindParam(":netPrice", $data["netPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":paymentMethod", $data["paymentMethod"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDIT SALE
	=============================================*/

	static public function mdlEditSale($table, $data)
	{

		$stmt = self::$conn->connect()->prepare("UPDATE $table SET  idCustomer = :idCustomer, idSeller = :idSeller, products = :products, tax = :tax, netPrice = :netPrice, totalPrice= :totalPrice, paymentMethod = :paymentMethod WHERE code = :code");

		$stmt->bindParam(":code", $data["code"], PDO::PARAM_INT);
		$stmt->bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
		$stmt->bindParam(":idSeller", $data["idSeller"], PDO::PARAM_INT);
		$stmt->bindParam(":products", $data["products"], PDO::PARAM_STR);
		$stmt->bindParam(":tax", $data["tax"], PDO::PARAM_STR);
		$stmt->bindParam(":netPrice", $data["netPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":paymentMethod", $data["paymentMethod"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	DELETE SALE
	=============================================*/

	static public function mdlDeleteSale($table, $data)
	{

		$stmt = self::$conn->connect()->prepare("DELETE FROM $table WHERE id = :id");

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
	DATES RANGE
	=============================================*/

	static public function mdlSalesDatesRange($table, $initialDate, $finalDate)
	{

		if ($initialDate == null) {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();
		} else if ($initialDate == $finalDate) {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table WHERE saledate like '%$finalDate%'");

			$stmt->bindParam(":saledate", $finalDate, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();
		} else {

			$actualDate = new DateTime();
			$actualDate->add(new DateInterval("P1D"));
			$actualDatePlusOne = $actualDate->format("Y-m-d");

			$finalDate2 = new DateTime($finalDate);
			$finalDate2->add(new DateInterval("P1D"));
			$finalDatePlusOne = $finalDate2->format("Y-m-d");

			if ($finalDatePlusOne == $actualDatePlusOne) {

				$stmt = self::$conn->connect()->prepare("SELECT * FROM $table WHERE saledate BETWEEN '$initialDate' AND '$finalDatePlusOne'");
			} else {


				$stmt = self::$conn->connect()->prepare("SELECT * FROM $table WHERE saledate BETWEEN '$initialDate' AND '$finalDate'");
			}

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}


	/*=============================================
	Adding TOTAL sales
	=============================================*/

	static public function mdlAddingTotalSales($table)
	{

		$stmt = self::$conn->connect()->prepare("SELECT SUM(netPrice) as total FROM $table");

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;
	}
}
$dbConnection = new Connection();
ModelSales::init($dbConnection);
