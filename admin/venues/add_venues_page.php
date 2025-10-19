<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/Showroom.php';
require_once __DIR__ . '/../../OOP/classes/Seating.php';

include '../../components/header.php';

$showroom = new Showroom();
$seating = new Seating();

// Handle Add
if (isset($_POST['addShowroom'])) {
    $name = $_POST['name'];
    $rows = intval($_POST['rows']);
    $seatsPerRow = intval($_POST['seatsPerRow']);

    $showroom->createWithSeating($name, $rows, $seatsPerRow);
    echo "<p class='text-green-600 text-center mt-4'>Showroom added successfully with seats!</p>";
    redirect_to("venues_page.php");
}

?>
<a href="venues_page">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Add Venues (Showrooms)</h2>

    <!-- Add New Showroom -->
    <div class="bg-amber-50 p-6 rounded-lg shadow mb-6">
        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="name" placeholder="Showroom Name" required class="border p-2 text-slate-800 rounded w-full">
            <input type="number" name="rows" placeholder="Rows" min="1" required class="border p-2 text-slate-800 rounded w-full">
            <input type="number" name="seatsPerRow" placeholder="Seats per Row" min="1" required class="border p-2 text-slate-800 rounded w-full">
            <button type="submit" name="addShowroom" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded w-max">
                Add Showroom
            </button>
        </form>
    </div>

</div>

<?php include '../../components/footer.php'; ?>
