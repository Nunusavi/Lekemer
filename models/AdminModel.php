<?php
require_once __DIR__ . '/../Database/Database.php'; // Correct path to Database class for DB connection
use App\Database;

class AdminModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public static function getUsers($limit = 5)
    {
        $db = Database::getInstance()->getConnection();
        $limit = (int)$limit; // Ensure integer
        $stmt = $db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public static function getTotalUsers()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as total FROM users");
        return $stmt->fetchColumn();
    }
    public static function getTotalCompanies()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as total FROM companies");
        return $stmt->fetchColumn();
    }
    public static function getSumTotalPayments()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT SUM(amount) as total FROM payments");
        return $stmt->fetchColumn();
    }
    public static function getCompanyStats()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT 
                    COUNT(*) as total_companies,
                    SUM(has_paid = 1) as active_companies,
                    SUM(has_paid = 0) as pending_companies
                  FROM companies";
        return $db->query($query)->fetch();
    }

    public static function getPaymentStats()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT 
                    SUM(amount) as total_revenue,
                    SUM(status = 'confirmed') as confirmed_payments,
                    SUM(status = 'pending') as pending_payments
                  FROM payments";
        return $db->query($query)->fetch();
    }

    public static function getRecentCompanies($limit = 5)
    {
        $db = Database::getInstance()->getConnection();
        $limit = (int)$limit;
        $stmt = $db->query("SELECT * FROM companies ORDER BY created_at DESC LIMIT $limit");
        return $stmt->fetchAll();
    }

    public static function getRecentPayments()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * from payments ORDER BY created_at DESC ");
        return $stmt->fetchAll();
    }

    public static function getRecentUsers($limit = 5)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT u.*, c.name as company_name 
                                   FROM users u
                                   JOIN companies c ON u.company_id = c.id
                                   ORDER BY u.created_at DESC ");
        return $stmt->fetchAll();
    }

    public static function getSubscriptionDistribution()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT subscription_plan, COUNT(*) as count 
                  FROM companies 
                  GROUP BY subscription_plan";
        return $db->query($query)->fetchAll();
    }

    public static function getPaymentDistribution()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT status, COUNT(*) as count 
                  FROM payments 
                  GROUP BY status";
        return $db->query($query)->fetchAll();
    }
    // Get user distribution by role
    public static function getUserDistributionByRole()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT role, COUNT(*) as count 
                  FROM users 
                  GROUP BY role";
        return $db->query($query)->fetchAll();
    }
    // Get Comapny Distribution by Subscription Plan
    public static function getCompanyDistributionByPlan()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT subscription_plan, COUNT(*) as count 
                  FROM companies 
                  GROUP BY subscription_plan";
        return $db->query($query)->fetchAll();
    }
    public static function getPayment(){
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM payments ORDER BY created_at DESC";
        return $db->query($query)->fetchAll();
    }
    // get companybyId
    public static function getCompanyById($companyId){
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM companies WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $companyId]);
        return $stmt->fetchAll();
    }
    // get user by Company id
    public static function getUsersByCompanyId($companyId){
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM users WHERE company_id = :company_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['company_id' => $companyId]);
        return $stmt->fetchAll();
    }
    public static function adminLogin($email)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM admin WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
