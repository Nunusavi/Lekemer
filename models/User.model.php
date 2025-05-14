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
				throw new Exception("Schema file not found at $schemaFilePath");
			}

			$schema = file_get_contents($schemaFilePath);
			if ($schema === false) {
				throw new Exception("Failed to read schema file at $schemaFilePath");
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
			$stmt2 = $conn->prepare("INSERT INTO users (company_id, name, email, phone, password) 
				VALUES (:company_id, :name, :email, :phone, :password)");
			$stmt2->execute([
				":company_id" => $companyId,
				":name" => $userData["full_name"],
				":email" => $userData["email"],
				":phone" => $userData["phone_number"],
				":password" => password_hash($userData["password"], PASSWORD_DEFAULT)
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
				"company_id" => $companyId
			];
		} catch (Exception $e) {
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

	static public function getCompanyById($company_id)
	{
		$conn = Database::getInstance()->getConnection();
		$stmt = $conn->prepare("SELECT * FROM companies WHERE id = :id LIMIT 1");
		$stmt->bindParam(":id", $company_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

}
