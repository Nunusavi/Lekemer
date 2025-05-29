<?php
require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . '/extension/vendor/autoload.php';


require_once __DIR__ . '/../config.php';


ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    

    private static function configureMailer($mail) {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "nathanmesfin919@gmail.com";
        $mail->Password = "wvfx wyhs veft sove";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('nathanmesfin919@gmail.com', 'Lekemer');
    }

    public static function sendPaymentConfirmationEmail($company, $paymentData) {
        try {
            $mailer = new PHPMailer(true);
            self::configureMailer($mailer);
            $mailer->clearAddresses();
            $mailer->addAddress($company['email'], $company['name']);

            $mailer->isHTML(true);
            $mailer->Subject = 'Payment Confirmation - ' . $company['name'];

            $message = "
            <html>
            <head>
                <title>Payment Confirmation</title>
                <style>
                    body { background-color: #f4f6f8; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; }
                    .header { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; padding: 30px 0 20px 0; text-align: center; }
                    .header h2 { margin: 0; font-size: 2em; letter-spacing: 1px; }
                    .content { padding: 32px 32px 24px 32px; }
                    .greeting { font-size: 1.1em; margin-bottom: 18px; }
                    .details-table { width: 100%; border-collapse: collapse; margin: 24px 0; }
                    .details-table th, .details-table td { padding: 12px 10px; text-align: left; }
                    .details-table th { background: #f1f3f6; color: #333; font-weight: 600; }
                    .details-table td { background: #fafbfc; }
                    .thanks { margin: 24px 0 0 0; font-size: 1.05em; }
                    .footer { background: #f8f9fa; color: #6c757d; text-align: center; padding: 18px 0; font-size: 0.95em; border-top: 1px solid #e9ecef; }
                    .support-link { color: #007bff; text-decoration: none; }
                    @media (max-width: 600px) {
                        .container { padding: 0; }
                        .content { padding: 20px 10px 16px 10px; }
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Payment Confirmation</h2>
                    </div>
                    <div class='content'>
                        <p class='greeting'>Hello " . htmlspecialchars($company['name']) . ",</p>
                        <p>We're excited to let you know that your payment has been successfully processed!</p>
                        <table class='details-table'>
                            <tr>
                                <th>Amount Paid</th>
                                <td><strong>" . htmlspecialchars($paymentData['amount']) . " ETB</strong></td>
                            </tr>
                            <tr>
                                <th>Subscription Plan</th>
                                <td>" . htmlspecialchars(ucfirst($company['subscription_plan'])) . "</td>
                            </tr>
                            <tr>
                                <th>Transaction ID</th>
                                <td>" . htmlspecialchars($paymentData['tx_ref']) . "</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>" . date('F j, Y', strtotime($paymentData['created_at'])) . "</td>
                            </tr>
                        </table>
                        <p class='thanks'>Thank you for choosing Lekemer! If you have any questions or need assistance, feel free to <a class='support-link' href='mailto:support@lekemer.com'>contact our support team</a>.</p>
                    </div>
                    <div class='footer'>
                        &copy; " . date('Y') . " Lekemer. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
            ";

            $mailer->Body = $message;
            $mailer->AltBody = strip_tags($message);

            return $mailer->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mailer->ErrorInfo);
            return false;
        }
    }

    public static function sendRenewalReminderEmail($company) {
        try {
            $mailer = new PHPMailer(true);
            self::configureMailer($mailer);
            $mailer->clearAddresses();
            $mailer->addAddress($company['email'], $company['name']);

            $mailer->isHTML(true);
            $mailer->Subject = 'Subscription Renewal Reminder - ' . $company['name'];

            $amount = self::getSubscriptionAmount($company['subscription_plan']);
            
            $message = "
            <html>
            <head>
                <title>Subscription Renewal Reminder</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #f8f9fa; padding: 15px; text-align: center; }
                    .content { padding: 20px; }
                    .footer { margin-top: 20px; font-size: 0.9em; color: #6c757d; }
                    .alert { background-color: #fff3cd; padding: 10px; border-radius: 4px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Subscription Renewal Reminder</h2>
                    </div>
                    <div class='content'>
                        <div class='alert'>
                            <p>Your subscription will renew in 3 days!</p>
                        </div>
                        <p>Dear " . htmlspecialchars($company['name']) . ",</p>
                        <p>Your <strong>" . htmlspecialchars($company['subscription_plan']) . "</strong> subscription will automatically renew on " . 
                        date('F j, Y', strtotime('+3 days')) . ".</p>
                        <p><strong>Renewal amount:</strong> " . $amount . " ETB</p>
                        <p>To update your payment method or subscription plan, please log in to your account.</p>
                        <p><a href='https://yourdomain.com/login' style='background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: inline-block;'>Login to Your Account</a></p>
                    </div>
                    <div class='footer'>
                        <p>If you have any questions, please contact our support team.</p>
                        <p>© " . date('Y') . " Lekemer. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mailer->Body = $message;
            $mailer->AltBody = strip_tags($message);

            return $mailer->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mailer->ErrorInfo);
            return false;
        }
    }

    private static function getSubscriptionAmount($plan) {
        $pricing = [
            'essential' => 750,
            'professional' => 1000,
            'enterprise' => 2000
        ];
        return $pricing[$plan] ?? 0;
    }
}
?>