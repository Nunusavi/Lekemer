<?php
require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . "/Controllers/UsersController.php";

use App\Controllers\UsersController;

session_start();
$company = $_SESSION['company'] ?? null;
$companyId = $company['id'] ?? null;
$selectedPlan = $company['subscription_plan'] ?? 'essential';
$company_email = $company['email'];
$users = UsersController::getUserbyCompanyId($companyId);
$phone = $users[0]['phone'] ?? '';
$pricing = [
    'essential' => 750,
    'professional' => 1000,
    'enterprise' => 2000
];
$amount = $pricing[$selectedPlan] ?? 750;
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout | Lekemer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .payment-error {
            display: none;
            color: #dc2626;
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #fee2e2;
            border-radius: 0.375rem;
        }

        .gradient-text {
            background: linear-gradient(90deg, #7c3aed, #0ea5e9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .fancy-spinner {
            border: 4px solid #e0e7ff;
            border-top: 4px solid #7c3aed;
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fancy-btn {
            background: linear-gradient(90deg, #7c3aed 0%, #0ea5e9 100%);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .fancy-btn:hover,
        .fancy-btn:focus {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 24px 0 rgba(124, 58, 237, 0.15);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.5);
            border: 1.5px solid #e0e7ff;
            transition: border 0.2s, box-shadow 0.2s;
        }

        .input-glass:focus {
            border: 1.5px solid #7c3aed;
            box-shadow: 0 0 0 2px #a5b4fc;
            background: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>

<body>
    <div id="paymentProcessingOverlay" class="fixed inset-0 min-w-screen min-h-screen bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="flex flex-col items-center">
            <div class="fancy-spinner mb-4"></div>
            <span class="text-white text-lg font-semibold">Processing payment, please wait...</span>
        </div>
    </div>
    <div class="py-20 min-h-screen flex items-center justify-center">
        <div class="max-w-5xl w-full mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Payment Form -->
                <div class="lg:col-span-2 max-md:order-1">
                    <div class="glass p-10 shadow-2xl">
                        <h2 class="text-4xl font-extrabold gradient-text mb-2 tracking-tight">Complete Your Payment</h2>
                        <p class="text-sky-600 text-lg mb-8">You're subscribing to the <span class="font-semibold"><?= ucfirst($selectedPlan) ?></span> plan</p>
                        <form id="paymentForm" method="POST" class="space-y-7">
                            <input type="hidden" name="plan" value="<?= $selectedPlan ?>">
                            <input type="hidden" name="amount" value="<?= $amount ?>">
                            <input type="hidden" name="company_id" value="<?= $companyId ?>">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" required
                                    class="input-glass w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-purple-400 transition"
                                    value="<?= $company_email ?? '' ?>">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" required pattern="(09|07)[0-9]{8}"
                                    class="input-glass w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-purple-400 transition"
                                    placeholder="09XXXXXXXX" value="0<?= $phone ?>">
                            </div>

                            <div id="paymentError" class="payment-error"></div>

                            <!-- Loading Spinner Overlay -->


                            <button type="submit" id="submitButton"
                                class="fancy-btn min-w-full md:w-auto px-8 py-3 text-white font-semibold rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 text-lg">
                                Pay <?= $amount ?> ETB Via Chapa
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="glass shadow-2xl p-8 flex flex-col justify-between font-[Inter,sans-serif] border-2 ">
                    <div>
                        <h2 class="text-3xl font-extrabold gradient-text mb-8 tracking-tight drop-shadow-lg">Order Summary</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium tracking-wide">Plan:</span>
                                <span class="font-semibold  text-lg px-3 py-1 rounded-full "><?= ucfirst($selectedPlan) ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium tracking-wide">Amount:</span>
                                <span class="font-semibold text-lg px-3 py-1 rounded-full"><?= $amount ?> ETB</span>
                            </div>
                        </div>
                        <div class="border-t-2 border-dashed border-indigo-200 pt-8 mt-8">
                            <div class="flex justify-between items-center mt-10">
                                <span class="font-bold text-xl text-black tracking-wide">Total:</span>
                                <span class="font-extrabold text-xl text-black px-4 py-1 "><?= $amount ?> ETB</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400 text-center">
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-400 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zm0 0c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3z"></path>
                            </svg>
                            <span class="font-semibold text-sky-500">Secure payment powered by Chapa</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitButton = document.getElementById('submitButton');
            const paymentProcessing = document.getElementById('paymentProcessingOverlay');
            const paymentError = document.getElementById('paymentError');

            // Reset UI
            paymentError.style.display = 'none';
            paymentProcessing.style.display = 'flex';
            submitButton.disabled = true;

            try {
                const formData = new FormData(form);

                const response = await fetch('Ajax/payment.ajax.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && data.checkout_url) {
                    window.location.href = data.checkout_url;
                } else {
                    throw new Error(data.message || 'Payment processing failed');
                }
            } catch (error) {
                console.error('Payment error:', error);
                paymentError.textContent = error.message;
                paymentError.style.display = 'block';
            } finally {
                paymentProcessing.style.display = 'none';
                submitButton.disabled = false;
            }
        });
    </script>
</body>

</html>