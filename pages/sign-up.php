<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
  <!-- <link rel="stylesheet" href="assets/css/app.min.css"> -->
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="container">
    <div class="Le-Kemer-form-header-logo" style="padding: 50px;">
      <a href="/Lekemer">
        <p id="name-logo" style="font-size: x-large;">Le-Kemer</p>
      </a>
    </div>
  </div>
  </div>
  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-4xl">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Register to Lekemer</h2>

    <form id="registerForm" method="post" class="space-y-6">
      <!-- Company Info -->
      <div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Company Info</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
            <input type="text" id="company_name" name="company_name"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
          </div>

          <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Company Address</label>
            <input type="text" id="address" name="address"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
          </div>

          <div class="md:col-span-2">
            <label for="subscription_plan" class="block text-sm font-medium text-gray-700">Subscription Plan</label>
            <select id="subscription_plan" name="subscription_plan"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
              <option value="" disabled selected>Select a plan</option>
              <option value="free">Free</option>
              <option value="starter">Starter</option>
              <option value="premium">Premium</option>
            </select>
          </div>
        </div>
      </div>

      <!-- User Info -->
      <div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">User Info</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="full_name" name="full_name"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              required>
          </div>

          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
          </div>

          <div class="md:col-span-2">
            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
            <p id="password_match_error" class="text-red-500 text-sm mt-1 hidden">Passwords do not match.</p>
          </div>
          <script>
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("confirm_password");
            const passwordError = document.getElementById("password_match_error");

            confirmPasswordInput.addEventListener("input", () => {
              if (confirmPasswordInput.value !== passwordInput.value) {
                confirmPasswordInput.classList.add("border-red-500");
                passwordError.classList.remove("hidden");
              } else {
                confirmPasswordInput.classList.remove("border-red-500");
                passwordError.classList.add("hidden");
              }
            });
          </script>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="text-center">
        <button type="submit"
          class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
          Register
        </button>
      </div>
    </form>
  </div>
</body>
<script>
  document.getElementById("registerForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
      const response = await fetch("Ajax/register.ajax.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (data.status === "ok") {
        // Create a success message element
        const successMessage = document.createElement("div");
        successMessage.className = "fixed top-4 right-4 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg transition-opacity duration-300 opacity-0";
        successMessage.textContent = "Registration successful. Please check your email to confirm.";

        // Append the message to the body
        document.body.appendChild(successMessage);

        // Show the message with a fade-in effect
        setTimeout(() => {
          successMessage.classList.remove("opacity-0");
        }, 100);

        // Remove the message after a few seconds with a fade-out effect
        setTimeout(() => {
          successMessage.classList.add("opacity-0");
          setTimeout(() => {
            successMessage.remove();
          }, 300); // Wait for the fade-out transition to complete
        }, 3000);
        window.location.href = "/Lekemer/sign-in";
      } else {
        alert("Error: " + (data.message || "Something went wrong"));
      }
    } catch (error) {
      console.error("Registration error:", error);
      alert("An unexpected error occurred. Please try again later.");
    }
  });
</script>


</html>