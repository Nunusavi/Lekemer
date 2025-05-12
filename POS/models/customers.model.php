<?php



require_once "connection.php";

class ModelCustomers
{
	 // Declare the static property
    private static $conn;

    // Static method to initialize the connection
    public static function init($dbConnection) {
        self::$conn = $dbConnection;
    }
	

	/*=============================================
	CREATE CUSTOMERS
	=============================================*/

	static public function mdlAddCustomer($table, $data)
	{

		$stmt = self::$conn->connect()->prepare("INSERT INTO $table(name, idDocument, email, phone, address, birthdate) VALUES (:name, :idDocument, :email, :phone, :address, :birthdate)");

		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":idDocument", $data["idDocument"], PDO::PARAM_INT);
		$stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
		$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
		$stmt->bindParam(":birthdate", $data["birthdate"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	SHOW CUSTOMERS
	=============================================*/

	static public function mdlShowCustomers($table, $item, $value)
	{

		if ($item != null) {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = self::$conn->connect()->prepare("SELECT * FROM $table");

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	EDIT CUSTOMER
	=============================================*/

	static public function mdlEditCustomer($table, $data)
	{

		$stmt = self::$conn->connect()->prepare("UPDATE $table SET name = :name, idDocument = :idDocument, email = :email, phone = :phone, address = :address, birthdate = :birthdate WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":idDocument", $data["idDocument"], PDO::PARAM_INT);
		$stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
		$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
		$stmt->bindParam(":birthdate", $data["birthdate"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	DELETE CUSTOMER
	=============================================*/

	static public function mdlDeleteCustomer($table, $data)
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
	UPDATE CUSTOMER
	=============================================*/

	static public function mdlUpdateCustomer($table, $item1, $value1, $value)
	{

		$stmt = self::$conn->connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE id = :id");

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
}
$dbConnection = new Connection();
ModelCustomers::init($dbConnection);