<?php
include 'components/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient pt-32 pb-20 px-6">
    <div class="container mx-auto">
        <div id="hero-carousel" class="relative w-full" data-carousel="static">
            <!-- Carousel Items -->
            <div class="relative h-[400px] overflow-hidden rounded-xl">
                <!-- Slide 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <div class="flex flex-col md:flex-row items-center h-full">
                        <div class="md:w-1/2 mb-10 md:mb-0">
                            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                                Experience Rowan <br> <span class="text-amber-400">Like Never Before</span>
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
                <!-- Slide 2 (example, duplicate and change content as needed) -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="flex flex-col md:flex-row items-center h-full">
                        <div class="md:w-1/2 mb-10 md:mb-0">
                            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                                Premium <span class="text-amber-400">Cinema Experience</span>
                            </h1>
                            <p class="text-lg text-gray-300 mb-8 max-w-lg">
                                Reclining seats, gourmet food, and state-of-the-art sound. Discover luxury movie nights!
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <button class="ticket-button px-8 py-3 rounded-full font-bold text-white">
                                    Book Premium
                                </button>
                                <button class="border border-amber-400 text-amber-400 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                                    Learn More
                                </button>
                            </div>
                        </div>
                        <div class="md:w-1/2 relative">
                            <div class="relative">
                                <img src="http://static.photos/theater/1024x576/1" alt="Premium Theater" class="rounded-xl shadow-2xl w-full">
                                <div class="absolute -bottom-5 -right-5 bg-amber-500 text-black px-4 py-2 rounded-full font-bold">
                                    Luxury Experience
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add more slides as needed -->
                <!-- Slide 2 (example, duplicate and change content as needed) -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="flex flex-col md:flex-row items-center h-full">
                        <div class="md:w-1/2 mb-10 md:mb-0">
                            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                                Premium <span class="text-amber-400">Cinema Experience</span>
                            </h1>
                            <p class="text-lg text-gray-300 mb-8 max-w-lg">
                                Reclining seats, gourmet food, and state-of-the-art sound. Discover luxury movie nights!
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <button class="ticket-button px-8 py-3 rounded-full font-bold text-white">
                                    Book Premium
                                </button>
                                <button class="border border-amber-400 text-amber-400 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                                    Learn More
                                </button>
                            </div>
                        </div>
                        <div class="md:w-1/2 relative">
                            <div class="relative">
                                <img src="http://static.photos/theater/1024x576/1" alt="Premium Theater" class="rounded-xl shadow-2xl w-full">
                                <div class="absolute -bottom-5 -right-5 bg-amber-500 text-black px-4 py-2 rounded-full font-bold">
                                    Luxury Experience
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel Controls -->
            <button type="button" class="absolute top-1/2 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black bg-opacity-50 group-hover:bg-opacity-80">
                    <i data-feather="chevron-left" class="text-white"></i>
                </span>
            </button>
            <button type="button" class="absolute top-1/2 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black bg-opacity-50 group-hover:bg-opacity-80">
                    <i data-feather="chevron-right" class="text-white"></i>
                </span>
            </button>
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

        <div class="mb-8">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-feather="calendar" class="text-gray-400 w-5 h-5"></i>
                </div>
                <input id="dateInput" datepicker type="text"
                    class="bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 p-2.5"
                    placeholder="Select date">
            </div>
        </div>

        <!-- Week Calendar -->
        <div class="flex overflow-x-auto pb-4 mb-8 scrollbar-hide">
            <div id="weekButtons" class="flex space-x-2"></div>
        </div>

        <script>
            function generateWeekButtons() {
                const container = document.getElementById('weekButtons');
                container.innerHTML = '';

                const today = new Date();
                const options = {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric'
                };

                for (let i = 0; i < 7; i++) {
                    const date = new Date(today);
                    date.setDate(today.getDate() + i);

                    const button = document.createElement('button');
                    button.className =
                        i === 0 ?
                        'bg-amber-500 text-black px-4 py-2 rounded-md font-medium min-w-[100px]' :
                        'bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]';

                    if (i === 0) {
                        button.textContent = 'Today';
                    } else if (i === 1) {
                        button.textContent = 'Tomorrow';
                    } else {
                        button.textContent = date.toLocaleDateString('en-US', options);
                    }

                    // Optional: clicking a date fills the date input
                    button.addEventListener('click', () => {
                        document.getElementById('dateInput').value = date.toLocaleDateString();
                    });

                    container.appendChild(button);
                }

                // Set date picker placeholder to today's date
                document.getElementById('dateInput').placeholder = today.toLocaleDateString();
            }

            generateWeekButtons();
        </script>



        <?php
        include 'components/movie_card.php';
        ?>

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
                    <span class="text-amber-400">Premium</span> Rowan Experience
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


<?php
include 'components/footer.php';
?>