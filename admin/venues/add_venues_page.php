<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/Showroom.php';
require_once __DIR__ . '/../../OOP/classes/Seating.php';


$showroom = new Showroom();
$seating = new Seating();

// Handle Add
if (isset($_POST['addShowroom'])) {
    $name = $_POST['name'];
    $rows = clamp(intval($_POST['rows']), 1, 15);
    $seatsPerRow = clamp(intval($_POST['seatsPerRow']), 1, 15);
    $showroom->createWithSeating($name, $rows, $seatsPerRow);
    
    redirect_to("venues_page.php");
}
include '../../components/header.php';

?>
<a href="venues_page.php">
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
            <input type="number" name="rows" placeholder="Rows" min="1" max="15" required class="border p-2 text-slate-800 rounded w-full">
            <input type="number" name="seatsPerRow" placeholder="Seats per Row" min="1" max="15" required class="border p-2 text-slate-800 rounded w-full">
            <button type="submit" name="addShowroom" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded w-max">
                Add Showroom
            </button>
        </form>
    </div>

</div>

<?php include '../../components/footer.php'; ?>
