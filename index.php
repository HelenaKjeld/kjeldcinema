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



<!-- Newsletter Section -->
<section class="py-16 px-6 bg-slate-900">
    <div class="container mx-auto max-w-4xl text-center">
        <h2 class="text-3xl font-bold mb-6" >Stay Updated</h2>
        <p class="text-lg text-gray-300 mb-8" data-aos="fade-up" data-aos-delay="100">
            Subscribe to our newsletter for exclusive offers, movie updates, and special events.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto"  data-aos-delay="200">
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