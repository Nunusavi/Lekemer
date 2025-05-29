<?php

require_once __DIR__ . "/Database.php";
use App\Database;
class CompaniesModel {

	/*=============================================
	REGISTER COMPANY
	=============================================*/
	static public function mdlRegisterCompany($table, $data) {

		$stmt = Database::getInstance()->getConnection()->prepare("INSERT INTO $table(name, email, password, token, confirmed) VALUES (:name, :email, :password, :token, 0)");

		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt->bindParam(":token", $data["token"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	CONFIRM ACCOUNT
	=============================================*/
	static public function mdlConfirmCompany($table, $token) {
		$stmt = Database::getInstance()->getConnection()->prepare("UPDATE $table SET confirmed = 1 WHERE token = :token");

		$stmt->bindParam(":token", $token, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return 'ok';
		} else {
			return 'error';
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	CHECK IF COMPANY EXISTS
	=============================================*/
	static public function mdlGetCompany($table, $item, $value) {

		$stmt = Database::getInstance()->getConnection()->prepare("SELECT * FROM $table WHERE $item = :$item");

		$stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
		$stmt = null;
	}
}
