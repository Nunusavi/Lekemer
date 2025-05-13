<?php

require_once "../controllers/companies.controller.php";
require_once "../models/companies.model.php";

class AjaxCompanies {

	/*=============================================
	REGISTER COMPANY
	=============================================*/
	public $companyName;
	public $email;
	public $password;

	public function ajaxRegisterCompany() {

		$data = [
			"name" => $this->companyName,
			"email" => $this->email,
			"password" => $this->password
		];

		$response = ControllerCompanies::ctrRegisterCompany($data);
		echo json_encode($response);
	}

	/*=============================================
	CONFIRM COMPANY
	=============================================*/
	public $token;

	public function ajaxConfirmCompany() {
		$response = ControllerCompanies::ctrConfirmCompany($this->token);
		echo json_encode($response);
	}
}

/*=============================================
ROUTE AJAX REQUESTS
=============================================*/

if (isset($_POST["companyName"])) {
	$register = new AjaxCompanies();
	$register->companyName = $_POST["companyName"];
	$register->email = $_POST["email"];
	$register->password = $_POST["password"];
	$register->ajaxRegisterCompany();
}

if (isset($_POST["token"])) {
	$confirm = new AjaxCompanies();
	$confirm->token = $_POST["token"];
	$confirm->ajaxConfirmCompany();
}
