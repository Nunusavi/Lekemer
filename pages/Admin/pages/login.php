<!-- pages/admin/login.php -->
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Replace with your admin validation logic
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php?page=admin/dashboard');
        exit;
    } else {
        $error = "Invalid login";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="stylesheet" href="assets/css/main.css">

<!-- Background effect -->
<div class="absolute inset-0 -z-10">
    <div class="absolute top-0 z-[-2] h-screen w-screen bg-[#000000] bg-[radial-gradient(#ffffff33_1px,#00091d_1px)] bg-[size:20px_20px]"></div>
    <style>
        html, body {
            overflow: hidden !important;
            height: 100%;
        }
    </style>
    <div></div>
</div>
<div class="flex items-center justify-center min-h-screen">
    <div class="container bg-slate-700 bg-opacity-50 max-w-md mx-auto xl:max-w-3xl flex rounded-lg shadow-3xl  overflow-hidden relative border border-zinc-800">
        <div class="hidden xl:flex xl:w-1/2 items-center justify-center bg-slate-800">
            <a href="/Lekemer">
                <p id="name-logo" class="text-center text-white" style="font-size: x-large;">Le-Kemer</p>
            </a>
        </div>
        <div class="w-full h-100 xl:w-1/2 p-8">
            <form method="POST" action="">
                <h1 class="text-2xl text-center font-bold text-white">Admin Portal</h1>
                <?php if (!empty($error)) echo "<p class='text-red-400 mt-2'>$error</p>"; ?>
                <div class="mb-4 mt-6">
                    <label class="block text-gray-300 text-sm font-semibold mb-2" for="username">
                        Username
                    </label>
                    <input
                        class="text-sm appearance-none rounded w-full py-2 px-3 text-gray-100 bg-zinc-800 border border-zinc-700 leading-tight focus:outline-none focus:ring-2 focus:ring-zinc-600 h-10 placeholder-gray-500"
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Your username"
                        required />
                </div>
                <div class="mb-6 mt-6">
                    <label class="block text-gray-300 text-sm font-semibold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="text-sm bg-zinc-800 border border-zinc-700 appearance-none rounded w-full py-2 px-3 text-gray-100 mb-1 leading-tight focus:outline-none focus:ring-2 focus:ring-zinc-600 h-10 placeholder-gray-500"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Your password"
                        required />
                    <a
                        class="inline-block align-baseline text-sm text-gray-500 hover:text-gray-300"
                        href="#">
                        Forgot Password?
                    </a>
                </div>
                <div class="flex w-full mt-8">
                    <button
                        class="w-full bg-zinc-800 hover:bg-zinc-700 text-white text-sm py-2 px-4 font-semibold rounded focus:outline-none focus:ring-2 focus:ring-zinc-600 h-10"
                        type="submit">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
