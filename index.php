<?php
include 'components/header.php';
?>

<?php
include 'components/news_section.php';
?>

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



        <?php
        include 'components/week_calender.php';
        ?>

        <?php
        include 'components/movie_card.php';
        ?>

    </div>
</section>


<?php
include 'components/coming_soon.php';
?>


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