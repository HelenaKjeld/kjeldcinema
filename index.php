<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RowanCinema - Your Ultimate Movie Experience</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        .movie-card {
            transition: all 0.3s ease;
        }
        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .ticket-button {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            transition: all 0.3s ease;
        }
        .ticket-button:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-black bg-opacity-90 backdrop-blur-md fixed w-full z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-amber-500 flex items-center">
                    <!-- <i class="mr-2"> </i> -->
                    <img src="img/mr_bean_icon.png" alt="icon" class="w-8 h-8 mr-1">
                        RowanCinema
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-white hover:text-amber-400 transition">Home</a>
                    <!-- <a href="#" class="text-white hover:text-amber-400 transition">Movies</a> -->
                    <a href="#" class="text-white hover:text-amber-400 transition">Venues</a>
                    <a href="#" class="text-white hover:text-amber-400 transition">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded-full font-medium transition">
                        Sign In
                    </button>
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
                <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Home</a>
                <!-- <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Movies</a> -->
                <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Venues</a>
                <a href="#" class="text-white text-2xl hover:text-amber-400 transition">Contact</a>
                <button class="bg-amber-500 hover:bg-amber-600 text-black px-6 py-3 rounded-full font-medium text-xl mx-auto w-48 transition">
                    Sign In
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20 px-6">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Experience Movies <br> <span class="text-amber-400">Like Never Before</span>
                    </h1>
                    <p class="text-lg text-gray-300 mb-8 max-w-lg">
                        Immerse yourself in stunning 4K projections with Dolby Atmos sound in our premium theaters.
                        Book your tickets now for the ultimate cinematic experience.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button class="ticket-button px-8 py-3 rounded-full font-bold text-white">
                            Book Tickets
                        </button>
                        <button class="border border-amber-400 text-amber-400 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                            Explore Movies
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="relative">
                        <img src="http://static.photos/black/1024x576/1" alt="Cinema" class="rounded-xl shadow-2xl w-full">
                        <div class="absolute -bottom-5 -right-5 bg-amber-500 text-black px-4 py-2 rounded-full font-bold">
                            Now Showing
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Now Showing Section -->
    <section class="py-16 px-6 bg-slate-900">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Now Showing</h2>
                <a href="#" class="flex items-center text-amber-400 hover:text-amber-300 transition">
                    View All <i data-feather="chevron-right" class="ml-1"></i>
                </a>
            </div>
            
            <!-- Date Picker -->
            <div class="mb-8">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-feather="calendar" class="text-gray-400 w-5 h-5"></i>
                    </div>
                    <input datepicker type="text" 
                           class="bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 p-2.5" 
                           placeholder="Select date">
                </div>
            </div>

            <!-- Week Calendar -->
            <div class="flex overflow-x-auto pb-4 mb-8 scrollbar-hide">
                <div class="flex space-x-2">
                    <button class="bg-amber-500 text-black px-4 py-2 rounded-md font-medium min-w-[100px]">
                        Today
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Tomorrow
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Wed, Jun 14
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Thu, Jun 15
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Fri, Jun 16
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Sat, Jun 17
                    </button>
                    <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]">
                        Sun, Jun 18
                    </button>
                </div>
            </div>
            
            <!-- Movie 1 -->
            <div class="bg-slate-800 rounded-xl overflow-hidden mb-12">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/4">
                        <img src="http://static.photos/movie/640x360/1" alt="Movie Poster" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/4 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h3 class="text-2xl font-bold">The Last Adventure</h3>
                            <div class="flex items-center text-amber-400">
                                <i data-feather="star" class="mr-1"></i>
                                <span>4.8/5</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Action</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Adventure</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Sci-Fi</span>
                        </div>
                        <p class="text-gray-300 mb-6">An epic journey through uncharted territories as a group of explorers search for a lost civilization.</p>
                        
                        <div>
                            <h4 class="font-medium mb-3">Showtimes</h4>
                            <div class="flex flex-wrap gap-3">
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">10:00 AM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">1:30 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">4:45 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">8:00 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">10:30 PM</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movie 2 -->
            <div class="bg-slate-800 rounded-xl overflow-hidden mb-12">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/4">
                        <img src="http://static.photos/movie/640x360/2" alt="Movie Poster" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/4 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h3 class="text-2xl font-bold">Midnight Dreams</h3>
                            <div class="flex items-center text-amber-400">
                                <i data-feather="star" class="mr-1"></i>
                                <span>4.5/5</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Drama</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Romance</span>
                        </div>
                        <p class="text-gray-300 mb-6">A poignant love story that unfolds under the stars, exploring the boundaries between dreams and reality.</p>
                        
                        <div>
                            <h4 class="font-medium mb-3">Showtimes</h4>
                            <div class="flex flex-wrap gap-3">
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">11:00 AM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">2:15 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">5:30 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">8:45 PM</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movie 3 -->
            <div class="bg-slate-800 rounded-xl overflow-hidden mb-12">
                <div class="flex flexocol md:flex-row">
                    <div class="md:w-1/4">
                        <img src="http://static.photos/movie/640x360/3" alt="Movie Poster" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/4 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h3 class="text-2xl font-bold">Cosmic Warriors</h3>
                            <div class="flex items-center text-amber-400">
                                <i data-feather="star" class="mr-1"></i>
                                <span>4.9/5</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Sci-Fi</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Action</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Fantasy</span>
                        </div>
                        <p class="text-gray-300 mb-6">An intergalactic battle for survival as warriors from different planets unite against a common enemy.</p>
                        
                        <div>
                            <h4 class="font-medium mb-3">Showtimes</h4>
                            <div class="flex flex-wrap gap-3">
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">10:30 AM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">1:45 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">5:00 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">8:15 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">11:30 PM</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movie 4 -->
            <div class="bg-slate-800 rounded-xl overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/4">
                        <img src="http://static.photos/movie/640x360/4" alt="Movie Poster" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/4 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h3 class="text-2xl font-bold">The Heist</h3>
                            <div class="flex items-center text-amber-400">
                                <i data-feather="star" class="mr-1"></i>
                                <span>4.7/5</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Thriller</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Crime</span>
                            <span class="text-xs bg-slate-700 px-2 py-1 rounded">Action</span>
                        </div>
                        <p class="text-gray-300 mb-6">A high-stakes robbery turns deadly as the thieves discover they've stolen more than they bargained for.</p>
                        
                        <div>
                            <h4 class="font-medium mb-3">Showtimes</h4>
                            <div class="flex flex-wrap gap-3">
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">12:00 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">3:30 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">7:00 PM</a>
                                <a href="booking_page" class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">10:15 PM</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Coming Soon Section -->
    <section class="py-16 px-6 bg-slate-800">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Coming Soon</h2>
                <a href="#" class="flex items-center text-amber-400 hover:text-amber-300 transition">
                    View All <i data-feather="chevron-right" class="ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Coming Soon Card 1 -->
                <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                    <div class="relative">
                        <img src="http://static.photos/movie/640x360/5" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center px-4">
                                <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">June 15</span>
                                <h3 class="text-xl font-bold text-white">Shadow Protocol</h3>
                                <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                    Notify Me
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Coming Soon Card 2 -->
                <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                    <div class="relative">
                        <img src="http://static.photos/movie/640x360/6" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center px-4">
                                <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">June 22</span>
                                <h3 class="text-xl font-bold text-white">Ocean's Legacy</h3>
                                <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                    Notify Me
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Coming Soon Card 3 -->
                <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                    <div class="relative">
                        <img src="http://static.photos/movie/640x360/7" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center px-4">
                                <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">July 5</span>
                                <h3 class="text-xl font-bold text-white">Lost in Time</h3>
                                <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                    Notify Me
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Coming Soon Card 4 -->
                <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                    <div class="relative">
                        <img src="http://static.photos/movie/640x360/8" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center px-4">
                                <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">July 12</span>
                                <h3 class="text-xl font-bold text-white">The Last Stand</h3>
                                <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                    Notify Me
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Experience Section -->
    <section class="py-20 px-6 bg-gradient-to-r from-slate-900 to-slate-800">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">
                        <span class="text-amber-400">Premium</span> Cinema Experience
                    </h2>
                    <p class="text-lg text-gray-300 mb-8 max-w-lg">
                        Indulge in our luxury theaters featuring reclining leather seats, gourmet food service, and state-of-the-art sound systems for the ultimate movie night.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <div class="bg-amber-500 p-2 rounded-full mr-3">
                                <i data-feather="headphones" class="text-black"></i>
                            </div>
                            <span class="font-medium">Dolby Atmos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-amber-500 p-2 rounded-full mr-3">
                                <i data-feather="maximize" class="text-black"></i>
                            </div>
                            <span class="font-medium">4K Projection</span>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-amber-500 p-2 rounded-full mr-3">
                                <i data-feather="coffee" class="text-black"></i>
                            </div>
                            <span class="font-medium">Gourmet Food</span>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-amber-500 p-2 rounded-full mr-3">
                                <i data-feather="trending-up" class="text-black"></i>
                            </div>
                            <span class="font-medium">Reclining Seats</span>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <div class="relative">
                        <img src="http://static.photos/theater/1024x576/1" alt="Premium Theater" class="rounded-xl shadow-2xl w-full">
                        <div class="absolute -bottom-5 -left-5 bg-white text-black px-4 py-2 rounded-full font-bold shadow-lg">
                            Luxury Experience
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 px-6 bg-slate-900">
        <div class="container mx-auto max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Stay Updated</h2>
            <p class="text-lg text-gray-300 mb-8" data-aos="fade-up" data-aos-delay="100">
                Subscribe to our newsletter for exclusive offers, movie updates, and special events.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto" data-aos="fade-up" data-aos-delay="200">
                <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-full bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button class="ticket-button px-8 py-3 rounded-full font-bold text-white whitespace-nowrap">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-12 px-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-amber-400 mb-4">RowanCinema</h3>
                    <p class="text-gray-400 mb-4">
                        Your ultimate destination for premium cinematic experiences.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Movies</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Cinemas</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Promotions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Information</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i data-feather="map-pin" class="mr-2"></i> 123 Cinema St, Movie City
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i data-feather="phone" class="mr-2"></i> (123) 456-7890
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i data-feather="mail" class="mr-2"></i> info@RowanCinema.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                <p>© 2025 RowanCinema. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileMenuButton.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                feather.replace();
            } else {
                icon.setAttribute('data-feather', 'x');
                feather.replace();
            }
        });

        // Close mobile menu when clicking a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuButton.querySelector('i');
                icon.setAttribute('data-feather', 'menu');
                feather.replace();
            });
        });

        // Replace feather icons
        feather.replace();
    </script>
</body>
</html>
