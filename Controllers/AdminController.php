<?php

require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . '/models/AdminModel.php';


class AdminController {
    public static function getTotalUsers() {
        return AdminModel::getTotalUsers();
    }
    public static function getTotalCompanies() {
        return AdminModel::getTotalCompanies();
    }
    public static function getSumTotalPayments() {
        return AdminModel::getSumTotalPayments();
    }
    public static function getCompanyStats() {
        return AdminModel::getCompanyStats();
    }
    public static function getPaymentStats() {
        return AdminModel::getPaymentStats();
    }
    public static function getTotalRevenue() {
        $stats = AdminModel::getPaymentStats();
        return $stats['total_revenue'] ?? 0;
    }
    public static function getTotalConfirmedPayments() {
        $stats = AdminModel::getPaymentStats();
        return $stats['confirmed_payments'] ?? 0;
    }
    public static function getTotalPendingPayments() {
        $stats = AdminModel::getPaymentStats();
        return $stats['pending_payments'] ?? 0;
    }
    public static function getCompanyStatsSummary() {
        $stats = AdminModel::getCompanyStats();
        return [
            'total_companies' => $stats['total_companies'] ?? 0,
            'active_companies' => $stats['active_companies'] ?? 0,
            'pending_companies' => $stats['pending_companies'] ?? 0
        ];
    }
    public static function getPaymentStatsSummary() {
        $stats = AdminModel::getPaymentStats();
        return [
            'total_revenue' => $stats['total_revenue'] ?? 0,
            'confirmed_payments' => $stats['confirmed_payments'] ?? 0,
            'pending_payments' => $stats['pending_payments'] ?? 0
        ];
    }
    /**
     * Get the latest users registered in the system.
     *
     * @param int $limit Number of users to retrieve.
     * @return array List of users.
     */

    public static function getUsers() {
        return AdminModel::getUsers();
    }
    public static function getRecentCompanies($limit = 5) {
        return AdminModel::getRecentCompanies($limit);
    }
    public static function getRecentPayments($limit = 5) {
        return AdminModel::getRecentPayments($limit);
    }
    public static function getPaymentDistribution() {
        return AdminModel::getPaymentDistribution();
    }
    public static function getCompanyDistributionByPlan() {
        return AdminModel::getCompanyDistributionByPlan();
    }
    public static function getUserDistributionByRole() {
        return AdminModel::getUserDistributionByRole();
    }
    public static function getPayment() {
        return AdminModel::getPayment();
    }
    public static function getUsersByCompanyId($companyId) {
        return AdminModel::getUsersByCompanyId($companyId);
    }
    private static function verifyPassword($inputPassword, $hashedPassword)
	{
		return password_verify($inputPassword, $hashedPassword);
	}
    public static function login($email, $password) {
        $user = AdminModel::adminLogin($email);
        if ($user && self::verifyPassword($password, $user['password'])) {

                return [
                    "status" => "success",
                    'user' => $_SESSION["user"] = [
                        "id" => $user['id'],
                        "name" => $user['name'],
                        "email" => $user['email'],
                    ],
                ];
            
        }
        return [
            "status" => "error",
            "message" => "Invalid email or password"
        ];
    }

}