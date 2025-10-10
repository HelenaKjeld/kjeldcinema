<?php require_once("includes/connection.php");?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
		if (logged_in()) 
    {
		  redirect_to("index.php");
	  }
    else
    {
      if (isset($_POST['submit'])) { // Form has been submitted.
		    $email = trim($_POST['email']);
		    $password = trim($_POST['password']);
        authenticate($email, $password);
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RowanCinema - Sign In</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="style.css" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="index min-h-screen flex flex-col">

<?php 
  include 'components/header.php';
?>

  <!-- Login Section -->
  <section class="hero-gradient flex-grow flex items-center justify-center pt-32 pb-20 px-6">
    <div class="bg-slate-800 bg-opacity-80 p-10 rounded-2xl shadow-2xl w-full max-w-md">
      <div class="text-center mb-6">
        <img src="img/Tedyy.webp" alt="Mr Bean" class="w-20 h-20 mx-auto mb-4 >
        <h2 class="text-3xl font-bold mb-2">
          Welcome Back, <span class="text-amber-400">Movie Bean!</span>
        </h2>
        <p class="text-gray-400">Sign in and grab your popcorn 🍿</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="bg-red-500 text-white text-sm rounded-lg p-3 mb-4 text-center">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block text-sm font-medium mb-2 text-gray-300">Email Address</label>
          <input 
            type="email" 
            name="email" 
            placeholder="bean@rowancinema.com" 
            required
            class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white focus:ring-2 focus:ring-amber-500 focus:outline-none border border-slate-600"
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium mb-2 text-gray-300">Password</label>
          <input 
            type="password" 
            name="password" 
            placeholder="•••••••• (not teddy!)" 
            required
            class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white focus:ring-2 focus:ring-amber-500 focus:outline-none border border-slate-600"
          />
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
        <button 
          type="submit" 
          class="ticket-button w-full py-3 rounded-full font-bold text-white text-center"
        >
          Sign In
        </button>
      </form>

      <p class="text-center text-gray-400 mt-6 text-sm">
        Don’t have an account?
        <a href="signup.php" class="text-amber-400 hover:underline">Sign Up</a>
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
