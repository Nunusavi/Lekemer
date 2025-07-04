<?php
require_once __DIR__ . './../../../Controllers/AdminController.php';
$users = AdminController::getUsers();
?>
<div class="min-w-xl overflow-hidden rounded-lg shadow-xs">
        <!-- Set a fixed height and make the table body scrollable, hide scrollbar -->
    <style>
        .custom-scrollbar {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: none;
            /* Firefox */
        }

        .custom-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }
    </style>
    <div class="w-full overflow-x-auto ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Company</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y  dark:divide-gray-700 dark:bg-gray-800">
                <?php if (!empty($users) && is_array($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        <img
                                            class="object-cover w-full h-full rounded-full"
                                            src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name'] ?? 'User'); ?>"
                                            alt=""
                                            loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold"><?php echo htmlspecialchars($user['name'] ?? ''); ?></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <?php echo htmlspecialchars($user['email'] ?? ''); ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <?php echo htmlspecialchars('0' . ($user['phone'] ?? 'N/A')); ?>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <?php
                                $status = ($user['is_verified'] ?? 0) ? 'Verified' : 'Unverified';
                                $class = ($user['is_verified'] ?? 0)
                                    ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100'
                                    : 'text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600';
                                ?>
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full <?php echo $class; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <?php
                                $date = $user['created_at'] ?? '';
                                if ($date) {
                                    echo htmlspecialchars(date('d-F-Y', strtotime($date)));
                                }
                                ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <?php foreach (AdminModel::getCompanyById($user['company_id']) as $company): ?>
                                        <p class="font-semibold"><?php echo htmlspecialchars($company['name'] ?? ''); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>