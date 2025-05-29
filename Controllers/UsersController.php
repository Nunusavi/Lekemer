<?php

namespace App\Controllers;

require_once __DIR__ . '/../config.php';
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');


require_once PROJECT_ROOT . '/extension/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\UsersModel;

require_once PROJECT_ROOT . '/models/UsersModel.php';



class UsersController
{
	static public function ctrRegisterUser($companyData, $userData)
	{
		$result = UsersModel::mdlRegisterUser($companyData, $userData);

		if ($result["status"] == "ok") {
			$emailStatus = self::sendConfirmationEmail($result["name"], $result["email"], $result["token"]);
			self::storePendingEmailInSession($result["email"]);
			return $emailStatus;
		} else {
			return $result;
		}
	}


	static public function authenticate($email, $password)
	{
		try {
			$user = UsersModel::loginUser($email);

			if ($user && self::verifyPassword($password, $user["password"])) {
				if (isset($user["is_verified"]) && $user["is_verified"] == 0) {
					return ["status" => "error", "message" => "Account not verified"];
				}
				$company = UsersModel::getCompanyById($user["company_id"]);
				if ($company) {
					self::storeUserSession($user, $company);
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
			error_log("Authentication error: " . $e->getMessage());
			return ["status" => "error", "message" => "An error occurred during authentication"];
		}
	}

	static public function ctrVerifyUserByToken($token)
	{
		$result = UsersModel::verifyUserByToken($token);

		if ($result && $result['status'] === 'ok' && isset($result['company'])) {
			if (session_status() !== PHP_SESSION_ACTIVE) {
				session_start();
			}
			$_SESSION['company'] = $result['company'];
		}

		return $result;
	}

	// --- Private Helper Methods ---

	private static function sendConfirmationEmail($name, $email, $token)
	{
		$mail = new PHPMailer(true);

		try {
			self::configureMailer($mail);
			$mail->addAddress($email, $name);
			$mail->isHTML(true);
			$mail->Subject = 'Verify Your Email Address';
			$mail->Body = self::getConfirmationEmailBody($name, $token);

			$mail->send();
			return ["status" => "ok", "message" => "Confirmation email sent"];
		} catch (Exception $e) {
			error_log("PHPMailer send failed: " . $mail->ErrorInfo);
			return ["status" => "error", "message" => "Failed to send confirmation email"];
		}
	}

	private static function configureMailer($mail)
	{
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true;
		$mail->Username = "nathanmesfin919@gmail.com";
		$mail->Password = "wvfx wyhs veft sove";
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;
		$mail->setFrom('nathanmesfin919@gmail.com', 'Lekemer');
	}

	private static function getConfirmationEmailBody($name, $token)
	{
		$link = "http://localhost/Lekemer/index.php?page=confirm-email&token=" . urlencode($token);
		$year = date('Y');
		return '
			<div style="font-family: \'Segoe UI\', Arial, sans-serif; background: #f4f8fb; padding: 40px;">
				<div style="max-width: 480px; margin: auto; background: #fff; border-radius: 18px; box-shadow: 0 6px 32px rgba(45,140,240,0.10); padding: 40px 36px 32px 36px;">
					<div style="text-align: center; margin-bottom: 28px;">
						<img src="https://img.icons8.com/color/96/2d8cf0/verified-account.png" alt="Lekemer" style="width: 64px; height: 64px;"/>
					</div>
					<h2 style="color: #2d8cf0; margin-bottom: 12px; font-weight: 700; font-size: 2rem; text-align: center;">
						Welcome, ' . htmlspecialchars($name) . '!
					</h2>
					<p style="font-size: 1.1rem; color: #222; text-align: center; margin-bottom: 28px;">
						Thanks for joining <b>Lekemer</b>.<br>
						To get started, please verify your email address.
					</p>
					<div style="text-align: center;">
						<a href="' . $link . '"
							style="display: inline-block; padding: 14px 36px; background: linear-gradient(90deg,#2d8cf0 0%,#5bb6ff 100%); color: #fff; text-decoration: none; border-radius: 6px; font-size: 1.1rem; font-weight: 600; box-shadow: 0 2px 8px rgba(45,140,240,0.08); transition: background 0.2s;">
							Verify Email
						</a>
					</div>
					<p style="font-size: 0.98rem; color: #888; margin-top: 32px; text-align: center;">
						If the button above doesn\'t work, copy and paste this link into your browser:
					</p>
					<p style="word-break: break-all; font-size: 0.98rem; color: #2d8cf0; background: #f0f6fc; padding: 10px 12px; border-radius: 4px; text-align: center;">
						' . $link . '
					</p>
					<hr style="margin: 36px 0 18px 0; border: none; border-top: 1px solid #e6eaf1;">
					<p style="font-size: 0.92rem; color: #b0b8c1; text-align: center;">
						If you did not request this, you can safely ignore this email.<br>
						&copy; ' . $year . ' Lekemer
					</p>
				</div>
			</div>
		';
	}

	private static function storePendingEmailInSession($email)
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$_SESSION['pending_email'] = $email;
	}

	private static function verifyPassword($inputPassword, $hashedPassword)
	{
		return password_verify($inputPassword, $hashedPassword);
	}

	private static function storeUserSession($user, $company)
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$_SESSION["loggedIn"] = true;
		$_SESSION["user_id"] = $user["id"];
		$_SESSION["role"] = $user["role"];
		$_SESSION["name"] = $user["name"];
		$_SESSION["email"] = $user["email"];
		$_SESSION["company_id"] = $company["id"];
		$_SESSION["company_db"] = [
			"host" => $company["db_host"],
			"company_name" => $company["name"],
			"name" => $company["db_name"],
			"user" => $company["db_user"],
			"password" => $company["db_password"]
		];

		return [
			"loggedIn" => $_SESSION["loggedIn"],
			"user_id" => $_SESSION["user_id"],
			"role" => $_SESSION["role"],
			"name" => $_SESSION["name"],
			"email" => $_SESSION["email"],
			"company_id" => $_SESSION["company_id"],
			"company_db" => $_SESSION["company_db"]
		];
	}

	public static function getUserByCompanyId($company_id)
	{
		return UsersModel::getUserByCompanyId($company_id);
	}
	public static function getCompanyByEmail($email)
	{
		UsersModel::getCompanyByEmail($email);
	}
	public static function getDataFromEmail($email)
	{
		$user = UsersModel::getUserByEmail($email);
		if ($user) {
			$company = UsersModel::getCompanyById($user["company_id"]);
			self::storeUserSession($user, $company);
					return [
						"status" => "success",
						"user_id" => $user["id"],
						"company_id" => $company["id"],
						"company_db" => $_SESSION["company_db"]
					];
		} else {
			return null;
		}
	}
}
