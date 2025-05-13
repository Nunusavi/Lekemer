<?php

require_once "../models/User.model.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class UsersController
{
	static public function ctrRegisterUser($companyData, $userData)
	{
		$result = UsersModel::mdlRegisterUser($companyData, $userData);

		if ($result["status"] == "ok") {
			// Registration successful
			return ["status" => "ok"];
		} else {
			// Registration failed
			return $result;
		}
	}
	static public function authenticate($email, $password) {
		try {
			$user = UsersModel::loginUser($email);

			if ($user && password_verify($password, $user["password"])) {
				$company = UsersModel::getCompanyById($user["company_id"]);

				if ($company) {
					// Store in session
					session_start();
					$_SESSION["logged_in"] = true;
					$_SESSION["user_id"] = $user["id"];
					$_SESSION["company_id"] = $company["id"];
					$_SESSION["company_db"] = [
						"host" => $company["db_host"],
						"name" => $company["db_name"],
						"user" => $company["db_user"],
						"password" => $company["db_password"]
					];

					return [
						"status" => "success",
						"user_id" => $user["id"],
						"company_id" => $company["id"],
						"company_db" => $_SESSION["company_db"]
					];
				} else {
					return ["status" => "error", "message" => "Company not found"];
				}
			} else {
				return ["status" => "error", "message" => "Invalid"];
			}
		} catch (Exception $e) {
			// Log the error and return a generic error message
			error_log("Authentication error: " . $e->getMessage());
			return ["status" => "error", "message" => "An error occurred during authentication"];
		}
	}
}
