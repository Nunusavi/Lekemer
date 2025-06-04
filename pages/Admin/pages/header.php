<!-- Header -->
 <?php
 session_start();
    $user = $_SESSION['name'] ?? 'kere';

 ?>
<div class="fixed w-full flex flex-row justify-between items-center h-14 text-white z-10">
    <div class="flex items-center justify-between md:justify-center pl-3 w-14 md:w-64 h-14 bg-blue-800 dark:bg-gray-800 border-none">
        <span class="w-5 h-5 md:w-5 md:h-5 mr-2 rounded-md overflow-hidden flex items-center justify-center hover:bg-blue-700 dark:hover:bg-gray-700 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 md:w-10 md:h-10 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </span>
        <span class="hidden md:block"><?php echo htmlspecialchars($user); ?></span>
    </div>
    <div class="flex justify-end items-center h-14 bg-blue-800 dark:bg-gray-800 header-right">
        <ul class="flex items-center">
            <li>
            </li>
            <li>
                <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
            </li>
            <li>
                <a href="" class="flex items-center mr-4 hover:text-blue-100">
                    <span class="inline-flex mr-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </span>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>