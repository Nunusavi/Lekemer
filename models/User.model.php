<?php
require_once "Database.php";
class UsersModel
{
	static public function mdlRegisterUser($companyData, $userData)
	{
		$conn = Database::getInstance()->getConnection();

		try {
			$conn->beginTransaction();

			// Generate database credentials
			$db_name = "pos_" . strtolower(preg_replace('/\s+/', '_', $companyData["company_name"])) . "_" . time();
			$db_user = "user_" . substr(md5(uniqid()), 0, 8);
			$db_pass = $userData["password"]; // raw password used for DB access
			$db_host = "localhost";

			// Create new DB
			$tempConn = new PDO("mysql:host=$db_host", "root", "");
			$tempConn->exec("CREATE DATABASE `$db_name`");

			// Import POS schema
			$schema = file_get_contents("../Database/posystem.sql");
			$posConn = new PDO("mysql:host=$db_host;dbname=$db_name", "root", "");
			$posConn->exec($schema);

			// Insert into companies
			$stmt1 = $conn->prepare("INSERT INTO companies (company_name, email, address, subscription_plan, db_name, db_host, db_user, db_password)
				VALUES (:company_name, :email, :address, :plan, :db_name, :db_host, :db_user, :db_password)");
			$stmt1->execute([
				":company_name" => $companyData["company_name"],
				":email" => $userData["email"],
				":address" => $companyData["address"],
				":plan" => $companyData["subscription_plan"],
				":db_name" => $db_name,
				":db_host" => $db_host,
				":db_user" => $db_user,
				":db_password" => $db_pass
			]);
			$companyId = $conn->lastInsertId();

			// Insert user in main db
			$token = bin2hex(random_bytes(32));
			$stmt2 = $conn->prepare("INSERT INTO users (company_id, name, email, phone, password) 
				VALUES (:company_id, :name, :email, :phone, :password)");
			$stmt2->execute([
				":company_id" => $companyId,
				":name" => $userData["full_name"],
				":email" => $userData["email"],
				":phone" => $userData["phone_number"],
				":password" => password_hash($userData["password"], PASSWORD_DEFAULT)
			]);

			$conn->commit();

			return [
				"status" => "ok",
				"token" => $token,
				"company_id" => $companyId
			];
		} catch (Exception $e) {
			$conn->rollBack();
			return ["status" => "error", "message" => $e->getMessage()];
		}
	}
}
