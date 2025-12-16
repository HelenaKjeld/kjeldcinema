<?php
require_once __DIR__ . '/../includes/session.php';
require_admin();  
include '../components/header.php';
?>

<div class="p-6">

    <h2 class="text-3xl font-bold mb-6">Welcome, Admin!</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="movies/movies_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage Movies</h3>
            <p class="text-gray-600 mt-2">Add, edit, or remove movies currently showing.</p>
        </a>

        <a href="news/news_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage News</h3>
            <p class="text-gray-600 mt-2">Create and edit latest cinema news.</p>
        </a>

        <a href="comingsoon/comingsoon_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Coming Soon</h3>
            <p class="text-gray-600 mt-2">Preview and manage upcoming releases.</p>
        </a>

        <a href="companyinfo/companyinfo_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Company Info</h3>
            <p class="text-gray-600 mt-2">Update company details and contact info.</p>
        </a>

        <a href="venues/venues_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Venues</h3>
            <p class="text-gray-600 mt-2">View all venues.</p>
        </a>

        <a href="manageusers/manageusers_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage Users</h3>
            <p class="text-gray-600 mt-2">View all registered users.</p>
        </a>
        <a href="managebooking/manage_bookings_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage Bookings</h3>
            <p class="text-gray-600 mt-2">View all booking.</p>
        </a>
        <a href="schedules/schedules_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage Schedules</h3>
            <p class="text-gray-600 mt-2">View movie schedule.</p>
        </a>
        <a href="manageabout/manage_about_page.php" class="bg-slate-800 shadow rounded-xl p-6 hover:bg-amber-500">
            <h3 class="text-xl font-semibold text-white"> Manage About page</h3>
            <p class="text-gray-600 mt-2">View about page.</p>
        </a>
    </div>
</div>



<?php
include '../components/footer.php';
?>