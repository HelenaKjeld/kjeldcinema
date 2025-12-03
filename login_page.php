<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/OOP/classes/User.php';

$userObj = new User();
$error = '';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';      // ⬅ lowercase
    $password = $_POST['password'] ?? ''; // ⬅ lowercase

    if ($userObj->login($email, $password)) {

        if (is_admin()) {
            header("Location: /admin/admin_page.php");
        } else {
            header("Location: /");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>


  <?php
  include 'components/header.php';
  ?>

  <!-- Login Section -->
  <section class="hero-gradient flex-grow flex items-center justify-center pt-32 pb-20 px-6">
    <div class="bg-slate-800 bg-opacity-80 p-10 rounded-2xl shadow-2xl w-full max-w-md">
      <div class="text-center mb-6">
        <img src="img/Tedyy.webp" alt="Mr Bean" class="w-20 h-20 mx-auto mb-4 >
        <h2 class=" text-3xl font-bold mb-2">
        Welcome Back, <span class="text-amber-400">Movie Bean!</span>
        </h2>
        <p class="text-gray-400">Sign in and grab your popcorn 🍿</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="bg-red-500 text-white text-sm rounded-lg p-3 mb-4 text-center">
          <?php echo politi($error); ?>
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block text-sm font-medium mb-2 text-gray-300">Email Address</label>
          <input
            type="email"
            name="email"
            placeholder="bean@rowancinema.com"
            required
            class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white focus:ring-2 focus:ring-amber-500 focus:outline-none border border-slate-600" />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium mb-2 text-gray-300">Password</label>
          <input
            type="password"
            name="password"
            placeholder="•••••••• (not teddy!)"
            required
            class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white focus:ring-2 focus:ring-amber-500 focus:outline-none border border-slate-600" />
        </div>

        <!-- Remember Me + Forgot -->
        <div class="flex items-center justify-between text-sm text-gray-400">
          <label class="flex items-center space-x-2">
            <input type="checkbox" class="form-checkbox rounded bg-slate-700 border-slate-600 text-amber-500" />
            <span>Remember me</span>
          </label>
          <a href="#" class="hover:text-amber-400 transition">Forgot Password?</a>
        </div>

        <!-- Submit Button -->
        <input
          name="submit"
          type="submit"
          class="ticket-button w-full py-3 rounded-full font-bold text-white text-center">
        Sign In
        </input>
      </form>

      <p class="text-center text-gray-400 mt-6 text-sm">
        Don’t have an account?
        <a href="/add_user.php" class="text-amber-400 hover:underline">Sign Up</a>
      </p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black text-white py-8 px-6">
    <div class="text-center text-gray-500 text-sm">
      © 2025 RowanCinema. All rights reserved.
      <br>Made with ❤️ and a dash of silliness by Mr. Bean
    </div>
  </footer>

  <script>
    feather.replace();
  </script>
</body>

</html>