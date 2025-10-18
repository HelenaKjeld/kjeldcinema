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
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $showroom->delete($id);
    echo "<p class='text-red-600 text-center mt-4'>Showroom deleted successfully.</p>";
}

// Fetch all showrooms
$rooms = $showroom->all();
?>

<a href="../admin_page">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Manage Venues (Showrooms)</h2>

    <!-- Add New Showroom -->
    <div class="bg-amber-50 p-6 rounded-lg shadow mb-6">
        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="name" placeholder="Showroom Name" required class="border p-2 rounded w-full">
            <input type="number" name="rows" placeholder="Rows" min="1" required class="border p-2 rounded w-full">
            <input type="number" name="seatsPerRow" placeholder="Seats per Row" min="1" required class="border p-2 rounded w-full">
            <button type="submit" name="addShowroom" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded w-max">
                Add Showroom
            </button>
        </form>
    </div>

    <!-- Showrooms List -->
    <?php if ($rooms): ?>
        <div class="space-y-6">
            <?php foreach ($rooms as $r): ?>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($r['name']) ?></h3>
                        <a href="?delete=<?= $r['ShowroomID'] ?>" 
                           onclick="return confirm('Delete this showroom and all its seats?');"
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</a>
                    </div>

                    <?php
                    $seats = $seating->getByShowroom($r['ShowroomID']);
                    $grouped = [];
                    foreach ($seats as $s) {
                        $grouped[$s['RowLetters']][] = $s['SeatNumber'];
                    }
                    ?>

                    <div class="mt-4">
                        <h4 class="font-semibold mb-2 text-gray-700">Seating Layout:</h4>
                        <div class="font-mono bg-gray-50 p-3 rounded border border-gray-200">
                            <?php foreach ($grouped as $row => $numbers): ?>
                                <p><?= $row ?>: <?= implode(', ', $numbers) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500 italic">No showrooms found. Add one above.</p>
    <?php endif; ?>
</div>

<?php include '../../components/footer.php'; ?>
