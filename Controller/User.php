<?php
require_once './Model/User.php';
require_once './Model/Company.php';

class UserController {
    public function register($userData, $companyData) {
        $companyModel = new Company();
        $userModel = new User();

        // Generate unique DB name
        $companyDbName = 'company_' . strtolower(preg_replace('/\s+/', '_', $companyData['name'])) . '_' . time();

        // 1. Create company DB
        if (!$companyModel->createCompanyDatabase($companyDbName)) {
            die("Failed to create company DB.");
        }

        // 2. Add company to central DB
        $companyId = $companyModel->createCompany(
            $companyData['name'],
            $companyData['email'],
            $companyDbName,
            'root', // Replace if dynamic
            ''      // Replace if dynamic
        );

        // 3. Add user to central DB
        if (!$userModel->createUser(
            $userData['name'],
            $userData['email'],
            $userData['password'],
            $companyId
        )) {
            die("Failed to create user.");
        }

        // 4. Load POS schema into new company DB
        if (!$companyModel->applySchemaToCompanyDB($companyDbName, './Schemas/posystem.sql')) {
            die("Failed to load schema.");
        }

        echo "Company and user registered successfully.";
    }
}
