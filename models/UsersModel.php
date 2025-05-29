<?php

namespace App\Models;

require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');

use App\Database;
use PDO;

require_once PROJECT_ROOT . '/extension/vendor/autoload.php';

require_once __DIR__ . '/../Database/Database.php';
class UsersModel
{
	static public function mdlRegisterUser($companyData, $userData)
	{
		$conn = Database::getInstance()->getConnection();

		try {
			$conn->beginTransaction();

			// Generate database credentials
			$db_name = "pos_" . strtolower(preg_replace('/\s+/', '_', $companyData["company_name"]));
			$db_user = "user_" . substr(md5(uniqid()), 0, 8);
			$db_pass = $userData["password"]; // raw password used for DB access
			$db_host = "localhost";

			// Create new DB
			$tempConn = new PDO("mysql:host=$db_host", "root", "");
			$tempConn->exec("CREATE DATABASE `$db_name`");

			// Import POS schema
			$schemaFilePath = realpath(__DIR__ . "/../Database/posystem.sql");
			if (!file_exists($schemaFilePath)) {
				throw new \Exception("Schema file not found at $schemaFilePath");
			}

			$schema = file_get_contents($schemaFilePath);
			if ($schema === false) {
				throw new \Exception("Failed to read schema file at $schemaFilePath");
			}

			$posConn = new PDO("mysql:host=$db_host;dbname=$db_name", "root", "");
			$posConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$posConn->exec($schema);



			// Create user and grant privileges
			$tempConn->exec("CREATE USER IF NOT EXISTS '$db_user'@'localhost' IDENTIFIED BY '$db_pass'");
			$tempConn->exec("GRANT ALL PRIVILEGES ON `$db_name`.* TO '$db_user'@'localhost' IDENTIFIED BY '$db_pass'");
			$tempConn->exec("FLUSH PRIVILEGES");

			// Insert into companies
			$stmt1 = $conn->prepare("INSERT INTO companies (name, email, address, subscription_plan, db_name, db_host, db_user, db_password)
				VALUES (:name, :email, :address, :plan, :db_name, :db_host, :db_user, :db_password)");
			$stmt1->execute([
				":name" => $companyData["company_name"],
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
			$stmt2 = $conn->prepare("INSERT INTO users (company_id, name, email, phone, password, verification_token) 
				VALUES (:company_id, :name, :email, :phone, :password, :token)");
			$stmt2->execute([
				":company_id" => $companyId,
				":name" => $userData["full_name"],
				":email" => $userData["email"],
				":phone" => $userData["phone_number"],
				":password" => password_hash($userData["password"], PASSWORD_DEFAULT),
				":token" => $token
			]);
			$userId = $conn->lastInsertId();
			// Get the user role 
			$stmt3 = $conn->prepare("SELECT role FROM users WHERE id = :id LIMIT 1");
			$stmt3->execute([":id" => $userId]);
			$userRole = $stmt3->fetchColumn();
			// Insert user into the new database
			$posConn->exec("INSERT INTO users (id, name, user, password, role, status) 
				VALUES ('$userId', '{$userData["full_name"]}', '$db_user', '" . password_hash($userData["password"], PASSWORD_DEFAULT) . "', '$userRole', 1)");

			$conn->commit();

			return [
				"status" => "ok",
				"company_id" => $companyId,
				"token" => $token,
				"name" => $userData["full_name"],
				"email" => $userData["email"]
			];
		} catch (\Exception $e) {
			$conn->rollBack();
			return ["status" => "error", "message" => $e->getMessage()];
		}
	}
	static public function loginUser($email)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	static public function getEmailById($user_id)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT email FROM users WHERE id = :id LIMIT 1");
		$stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	static public function saveTransaction($user_id, $amount, $tx_ref, $status)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("INSERT INTO payments(user_id, amount, tx_ref, status) VALUES (:user_id, :amount, :tx_ref, :status)");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":amount", $amount, PDO::PARAM_STR);
		$stmt->bindParam(":tx_ref", $tx_ref, PDO::PARAM_STR);
		$stmt->bindParam(":status", $status, PDO::PARAM_STR);
		if ($stmt->execute()) {
			return ["status" => "ok", "message" => "Transaction saved successfully."];
		} else {
			return ["status" => "error", "message" => $conn->errorInfo()[2] ?? "Failed to save transaction."];
		}
	}

	static public function updatePaymentStatus($tx_ref, $status)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("UPDATE payments SET status = :status WHERE tx_ref = :tx_ref");
		$stmt->bindParam(":status", $status, PDO::PARAM_STR);
		$stmt->bindParam(":tx_ref", $tx_ref, PDO::PARAM_STR);
		if ($stmt->execute()) {
			return ["status" => "ok", "message" => "Payment status updated successfully."];
		} else {
			return ["status" => "error", "message" => $conn->errorInfo()[2] ?? "Failed to update payment status."];
		}
	}

	static public function verifyUserByToken($token)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE verification_token = :token LIMIT 1");
		$stmt->bindParam(":token", $token, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($user) {
			$update = $conn->prepare("UPDATE users SET is_verified = 1 WHERE id = :id");
			$update->bindParam(":id", $user['id'], PDO::PARAM_INT);
			if ($update->execute()) {
				// Fetch company data
				$stmtCompany = $conn->prepare("SELECT * FROM companies WHERE id = :company_id LIMIT 1");
				$stmtCompany->bindParam(":company_id", $user['company_id'], PDO::PARAM_INT);
				$stmtCompany->execute();
				$company = $stmtCompany->fetch(PDO::FETCH_ASSOC);

				return [
					"status" => "ok",
					"message" => "Email verification successful!",
					"company" => $company
				];
			} else {
				return ["status" => "error", "message" => $conn->errorInfo()[2] ?? "Failed to update user."];
			}
		} else {
			return ["status" => "error", "message" => "Invalid token!"];
		}
	}
	static public function getUserByEmail($email)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	static public function getUserById($id)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public static function getCompanyById($companyId)
	{
		// Replace this with your actual database logic
		// Example using PDO:
		$db = Database::getInstance()->getConnection();
		$stmt = $db->prepare("SELECT * FROM companies WHERE id = :id");
		$stmt->execute(['id' => $companyId]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public static function lastInsertId()
	{
		$conn = Database::getInstance()->getConnection();
		return $conn->lastInsertId();
	}
	public static function updateCompany($tx_ref, $fields)
	{
		$conn = Database::getInstance()->getConnection();

		$parts = explode('-', $tx_ref);
		$companyId = end($parts);

		$set = [];
		$params = [];

		foreach ($fields as $key => $value) {
			$set[] = "$key = :$key";
			$params[$key] = $value;
		}
		$params['id'] = $companyId;
		$sql = "UPDATE companies SET " . implode(', ', $set) . " WHERE id = :id";
		$stmt = $conn->prepare($sql);

		return $stmt->execute($params);
	}

	public static function sucessPayment($companyID){
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("UPDATE companies SET has_paid = 1 WHERE id = :company_id");
		$stmt->bindParam(":company_id", $companyID, PDO::PARAM_INT);
		$stmt->execute();
	}

	public static function getUserByCompanyId($companyId)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE company_id = :company_id");
		$stmt->bindParam(":company_id", $companyId, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public static function getCompanyByEmail($email)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM companies WHERE email = :email LIMIT 1");
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}
