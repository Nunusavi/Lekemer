<?php
require_once __DIR__ . '/../config.php';
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');
require_once PROJECT_ROOT . '/extension/vendor/autoload.php';
require_once __DIR__ . '/../Database/Database.php'; // Correct path to Database class for DB connection
use App\Database;

class PaymentModel
{

    public static function savePayment($data)
    {
        $conn = Database::getInstance()->getConnection();
        $query = "INSERT INTO payments 
                  (company_id, amount, payment_date, transaction_id, status) 
                  VALUES 
                  (:company_id, :amount, :payment_date, :transaction_id, :status)";

        $stmt = $conn->prepare($query);

        return $stmt->execute([
            ':company_id' => $data['company_id'],
            ':amount' => $data['amount'],
            ':payment_date' => $data['payment_date'] ?? date('Y-m-d H:i:s'),
            ':transaction_id' => $data['transaction_id'] ?? null,
            ':status' => $data['status'] ?? 'pending'
        ]);
    }
     public static function updatePaymentStatus($transactionId)
    {
        $conn = Database::getInstance()->getConnection();
        $query = "UPDATE payments SET status = 'confirmed' WHERE transaction_id = :transaction_id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':transaction_id' => $transactionId]);
        
    }

    public static function getPaymentsByCompany($companyId)
    {
        $conn = Database::getInstance()->getConnection();
        $query = "SELECT * FROM payments WHERE company_id = :company_id ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute([':company_id' => $companyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPendingPayments()
    {
        $conn = Database::getInstance()->getConnection();
        $query = "SELECT * FROM payments WHERE status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUpcomingRenewals($days = 3)
    {
        $conn = Database::getInstance()->getConnection();
        $query = "SELECT c.* FROM companies c
                  JOIN payments p ON c.id = p.company_id
                  WHERE p.status = 'confirmed'
                  AND DATE_ADD(p.payment_date, INTERVAL 1 MONTH) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL :days DAY)
                  GROUP BY c.id";

        $stmt = $conn->prepare($query);
        $stmt->execute([':days' => $days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPaymentById($paymentId)
    {
        $conn = Database::getInstance()->getConnection();
        $query = "SELECT * FROM payments WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $paymentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function lastInsertId()
    {
        $conn = Database::getInstance()->getConnection();
        return $conn->lastInsertId();
    }
}
