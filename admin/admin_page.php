<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
include '../components/header.php';
?>

<div class="p-6">

    <h2 class="text-3xl font-bold mb-6">Welcome, Admin!</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="movies/movies_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Manage Movies</h3>
            <p class="text-gray-600 mt-2">Add, edit, or remove movies currently showing.</p>
        </a>

        <a href="news/news_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Manage News</h3>
            <p class="text-gray-600 mt-2">Create and edit latest cinema news.</p>
        </a>

        <a href="comingsoon/comingsoon_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Coming Soon</h3>
            <p class="text-gray-600 mt-2">Preview and manage upcoming releases.</p>
        </a>

        <a href="companyinfo/companyinfo_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Company Info</h3>
            <p class="text-gray-600 mt-2">Update company details and contact info.</p>
        </a>

        <a href="venues/venues_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Venues</h3>
            <p class="text-gray-600 mt-2">View all venues.</p>
        </a>

        <a href="manageusers/manageusers_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Manage Users</h3>
            <p class="text-gray-600 mt-2">View all registered users.</p>
        </a>
        <a href="managebooking/manage_bookings_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Manage Bookings</h3>
            <p class="text-gray-600 mt-2">View all booking.</p>
        </a>
        <a href="schedules/schedules_page.php" class="bg-white shadow rounded-xl p-6 hover:bg-amber-50">
            <h3 class="text-xl font-semibold text-slate-800"> Manage Schedules</h3>
            <p class="text-gray-600 mt-2">View movie schedule.</p>
        </a>
    </div>
</div>



<?php
include '../components/footer.php';
?>