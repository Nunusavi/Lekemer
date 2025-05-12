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
}
