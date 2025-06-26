<?php
require_once __DIR__ . '/../config.php';
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');

require_once PROJECT_ROOT . '/extension/vendor/autoload.php';

require_once PROJECT_ROOT . '/models/PaymentModel.php';
require_once PROJECT_ROOT . '/models/UsersModel.php';
require_once PROJECT_ROOT . '/Controllers/mailer.php';

use App\Models\UsersModel;

class PaymentController
{



    public static function initiatePayment($data)
    {
        $companyId = $data['company_id'] ?? null;
        $plan = $data['plan'] ?? null;
        $amount = $data['amount'] ?? null;
        $email = $data['email'] ?? null;
        $phone = $data['phone'] ?? null;
        if (!$companyId || !$plan || !$amount || !$email || !$phone) {
            return ['Missing' => false, 'message' => 'Missing required fields'];
        }

        // Get company details
        $company = UsersModel::getCompanyById($companyId);

        if (!$company) {
            return ['success' => false, 'message' => 'Company not found'];
        }



        // Create pending payment record
        $paymentData = [
            'company_id' => $companyId,
            'amount' => $amount,
            'status' => 'pending',
            'transaction_id' => 'tx-' . time() . '-' . $company['id'],
        ];

        if (PaymentModel::savePayment($paymentData)) {
            // Initialize Chapa payment
            return self::initiateChapaPayment($company, $amount, $paymentData['transaction_id']);
        }


        return ['success' => false, 'message' => 'Failed to create payment record'];
    }

    private static function getSubscriptionAmount($plan)
    {
        $pricing = [
            'essential' => 750,
            'professional' => 1000,
            'enterprise' => 2000
        ];
        return $pricing[$plan] ?? 0;
    }

    private static function initiateChapaPayment($company, $amount, $transactionId)
    {
        $chapa_url = 'https://api.chapa.co/v1/transaction/initialize';
        $secret_key = 'CHASECK_TEST-s6labTR7g6sm7ReBMFSzYFIwnW6xWpBf';

        $data = [
            'amount' => $amount,
            'currency' => 'ETB',
            'email' => $company['email'],
            'first_name' => explode(' ', $company['name'])[0],
            'last_name' => explode(' ', $company['name'])[1] ?? '',
            'tx_ref' => $transactionId,
            'callback_url' => 'https://localhost/Lekemer/payment_verification',
            'return_url' => 'https://localhost/Lekemer/payment_verification?tx_ref=' . urlencode($transactionId),
            'customization' => [
                'title' => 'Subscription',
                'description' => $company['subscription_plan'] . ' Plan Payment'
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $chapa_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $secret_key,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ['success' => false, 'message' => 'Payment gateway error: ' . $err];
        }

        $result = json_decode($response, true);
        if ($result['status'] == 'success') {
            return [
                'success' => true,
                'checkout_url' => $result['data']['checkout_url'],
                'payment_id' => PaymentModel::lastInsertId()
            ];
        } else {
            return ['success' => false, 'message' => $result['message'] ?? 'Payment initiation failed'];
        }
    }

    public static function verifyPayment($transactionRef)
    {
        $secret_key = 'CHASECK_TEST-s6labTR7g6sm7ReBMFSzYFIwnW6xWpBf';
        $chapa_url = 'https://api.chapa.co/v1/transaction/verify/' . $transactionRef;


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chapa.co/v1/transaction/verify/' . urlencode($transactionRef),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer CHASECK_TEST-s6labTR7g6sm7ReBMFSzYFIwnW6xWpBf'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        if ($result['status'] == 'success') {
            // Extract company ID from transaction reference
            $parts = explode('-', $result['data']['tx_ref']);
            $companyId = end($parts);
            
            // Update payment status
            PaymentModel::updatePaymentStatus(
                $result['data']['tx_ref'] // Chapa transaction ID
            );

            // Update company payment status
            UsersModel::sucessPayment($companyId);
            $result = $result['data'];

            // Send confirmation email
            $company = UsersModel::getCompanyById($companyId);
            Mailer::sendPaymentConfirmationEmail($company, $result);

            return ['success' => true, 'message' => 'Payment verified successfully'];
        }

        return ['success' => false, 'message' => 'Payment verification failed'];
    }

    public function sendRenewalReminders()
    {
        $companies = PaymentModel::getUpcomingRenewals(3); // 3 days before renewal

        foreach ($companies as $company) {
            Mailer::sendRenewalReminderEmail($company);
        }

        return ['success' => true, 'message' => 'Sent reminders to ' . count($companies) . ' companies'];
    }

    public static function verifyNow($trx_ref, $ref_id)
    {
        $chapaSecret = 'CHASECK_TEST-s6labTR7g6sm7ReBMFSzYFIwnW6xWpBf';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.chapa.co/v1/transaction/verify/$ref_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $chapaSecret"
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === 'success') {

            $saved = PaymentModel::updatePaymentStatus($trx_ref, $ref_id, $result['data']);

            if ($saved) {
                return [
                    "success" => true,
                    "redirect_to" => "/POS" // ✅ Set your post-payment redirect
                ];
            } else {
                return ["success" => false, "error" => "Failed to record payment."];
            }
        } else {
            return ["success" => false, "error" => "Verification failed."];
        }
    }
}
