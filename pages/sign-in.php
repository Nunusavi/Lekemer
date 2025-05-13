<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign In</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.cdnfonts.com/css/beyonders" rel="stylesheet">

  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:wght@100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/custom-font.css">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/aos.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/splitting.css">
  <link rel="stylesheet" href="assets/css/icomoon.css">

  <!-- Code Editor  -->

  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-row justify-center items-center flex-nowrap gap-5">
  <div class="container w-auto">
    <div class="Le-Kemer-form-header-logo pb-3 text-center" style="padding:px;">
      <a href="/Lekemer">
        <p id="name-logo" style="font-size: x-large;">Le-Kemer</p>
      </a>
    </div>
    <div class="text-center">
        <span class="text-sm text-gray-600">Don’t have an account?</span>
        <a href="/Lekemer/sign-up" class="text-sm text-blue-600 hover:underline">Sign Up</a>
      </div>
  </div>
  <div class="bg-white flex-1  p-8 rounded-2xl shadow-md w-full max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Sign In to Lekemer POS</h2>

    <form id="loginForm" method="post" class="space-y-6">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email"
          class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password"
          class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" id="remember_me" name="remember_me"
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
          <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
        </div>
        <div>
          <a href="#" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
        </div>
      </div>

      <div class="text-center">
        <button type="submit"
          class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
          Sign In
        </button>
      </div>

      
    </form>
  </div>
</body>

<script>
  document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const email = formData.get("email");
    const password = formData.get("password");

    try {
      // First fetch logic
      const response = await fetch("Ajax/login.ajax.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data?.status === "success") {
        window.location.href = "/Lekemer/POS/";
      } else {
        alert(`Error: ${data?.message || "Invalid credentials"}`);
      }
    } catch (error) {
      console.error("Login error:", error);
      alert("An unexpected error occurred. Please try again later.");
    }

  });
</script>

</html>