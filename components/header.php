<?php require_once("includes/session.php"); ?>

 
 <nav class="bg-black bg-opacity-90 backdrop-blur-md w-full z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="index" class="text-2xl font-bold text-amber-500 flex items-center">
                    <!-- <i class="mr-2"> </i> -->
                    <img src="img/mr_bean_icon.png" alt="icon" class="w-16 h-16 mr-1">
                        RowanCinema
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index" class="text-white hover:text-amber-400 transition">Home</a>
                    <!-- <a href="#" class="text-white hover:text-amber-400 transition">Movies</a> -->
                    <a href="venues_page" class="text-white hover:text-amber-400 transition">Venues</a>
                    <a href="#" class="text-white hover:text-amber-400 transition">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php 
                      if (logged_in()) {
                        echo ' <a href="logout_page"><button class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded-full font-medium transition">
                        Sign out
                    </button></a>';
                      } else {
                        echo '<a href="login_page"><button class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded-full font-medium transition">
                        Sign In
                    </button></a>';
                      }
                   
                    ?>
                    <button class="md:hidden text-white" id="mobile-menu-button">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="fixed inset-0 bg-black bg-opacity-90 z-40 hidden" id="mobile-menu">
        <div class="container mx-auto px-6 py-20">
            <div class="flex flex-col space-y-8 text-center">
                <a href="index" class="text-white text-2xl hover:text-amber-400 transition">Home</a>
                <!-- <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Movies</a> -->
                <a href="venues_page" class="text-white text-2xl hover:text-amber-400 transition">Venues</a>
                <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Contact</a>
                <button class="bg-amber-500 hover:bg-amber-600 text-black px-6 py-3 rounded-full font-medium text-xl mx-auto w-48 transition">
                    Sign In
                </button>
            </div>
        </div>
    </div>