<?php

require_once "models/companies.model.php";

class ControllerCompanies {

	/*=============================================
	REGISTER COMPANY
	=============================================*/
	static public function ctrRegisterCompany($data) {
		$table = "companies";
		$data["token"] = bin2hex(random_bytes(16));
		$data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

		$response = CompaniesModel::mdlRegisterCompany($table, $data);

		if ($response == "ok") {
			// Send confirmation email
			$link = "http://yourdomain.com/confirm?token=" . $data["token"];
			mail($data["email"], "Confirm your account", "Click to confirm: $link");

			// Provision DB here (see next step)
		}

		return $response;
	}

	/*=============================================
	CONFIRM COMPANY
	=============================================*/
	static public function ctrConfirmCompany($token) {
		$table = "companies";
		return CompaniesModel::mdlConfirmCompany($table, $token);
	}

	/*=============================================
	CHECK IF COMPANY EXISTS
	=============================================*/
	static public function ctrGetCompany($item, $value) {
		$table = "companies";
		return CompaniesModel::mdlGetCompany($table, $item, $value);
	}
}
