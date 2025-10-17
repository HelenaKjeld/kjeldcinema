<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/Showroom.php';
require_once __DIR__ . '/../../OOP/classes/Seating.php';

$showroom = new Showroom();
$seating = new Seating();

include '../../components/header.php';

// Handle Add Showroom (with seat generation)
if (isset($_POST['addShowroom'])) {
    $name = trim($_POST['name']);
    $rows = intval($_POST['rows']);
    $seatsPerRow = intval($_POST['seatsPerRow']);

    if ($rows > 0 && $rows <= 26 && $seatsPerRow > 0) {
        // Create the showroom
        $showroomID = $showroom->create(['name' => $name]);

        // Generate seating automatically
        $alphabet = range('A', 'Z');
        for ($r = 0; $r < $rows; $r++) {
            $rowLetter = $alphabet[$r];
            for ($s = 1; $s <= $seatsPerRow; $s++) {
                $seating->create([
                    'RowLetters' => $rowLetter,
                    'SeatNumber' => $s,
                    'ShowroomID' => $showroomID
                ]);
            }
        }

        echo "<p class='text-green-600 text-center mt-4'>Showroom <strong>$name</strong> created successfully with seating!</p>";
    } else {
        echo "<p class='text-red-600 text-center mt-4'>Invalid number of rows or seats per row.</p>";
    }
}

// Handle Delete Showroom
if (isset($_GET['deleteShowroom'])) {
    $id = intval($_GET['deleteShowroom']);
    $showroom->delete($id);
    $seating->deleteByShowroom($id);
    echo "<p class='text-red-600 text-center mt-4'>Showroom and its seating deleted successfully!</p>";
}

$showrooms = $showroom->getAll();
?>

<a href="../admin_page">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Venues (Showrooms & Seating)</h2>

    <!-- Add Showroom -->
    <form method="POST" class="bg-white p-4 rounded shadow mb-6 max-w-xl mx-auto">
        <h3 class="text-lg font-semibold mb-3 text-slate-800">Add New Showroom</h3>
        <input type="text" name="name" placeholder="Showroom Name" required class="border p-2 w-full mb-3 text-slate-800">
        <input type="number" name="rows" placeholder="Number of Rows (A–Z)" required min="1" max="26" class="border p-2 w-full mb-3 text-slate-800">
        <input type="number" name="seatsPerRow" placeholder="Seats per Row" required min="1" class="border p-2 w-full mb-3 text-slate-800">
        <button type="submit" name="addShowroom" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">Add Showroom</button>
    </form>

    <!-- Showrooms -->
    <div class="space-y-6">
        <?php foreach ($showrooms as $room): ?>
            <div class="bg-white p-4 rounded shadow">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-slate-800"><?= htmlspecialchars($room['name']) ?></h3>
                    <a href="?deleteShowroom=<?= $room['ShowroomID'] ?>" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                       onclick="return confirm('Delete this showroom and all seats?')">Delete</a>
                </div>

                <!-- Seating Section -->
                <button onclick="toggleSeating(<?= $room['ShowroomID'] ?>)" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                    View Seating
                </button>

                <div id="seating<?= $room['ShowroomID'] ?>" class="hidden mt-4">
                    <?php
                    $seats = $seating->getByShowroom($room['ShowroomID']);
                    if ($seats):
                        $rows = [];
                        foreach ($seats as $seat) {
                            $rows[$seat['RowLetters']][] = $seat;
                        }
                    ?>
                        <div class="bg-gray-100 p-4 rounded-lg inline-block">
                            <?php foreach ($rows as $rowLetter => $rowSeats): ?>
                                <div class="flex items-center mb-2">
                                    <span class="font-bold w-6 text-slate-700"><?= $rowLetter ?></span>
                                    <?php foreach ($rowSeats as $seat): ?>
                                        <div class="w-8 h-8 flex items-center justify-center m-1 rounded-md text-white text-sm
                                            <?= $seat['IsAvailable'] ? 'bg-green-500' : 'bg-red-500' ?>">
                                            <?= $seat['SeatNumber'] ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 italic mb-3">No seats found.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function toggleSeating(id) {
    document.getElementById('seating' + id).classList.toggle('hidden');
}
</script>

<?php include '../../components/footer.php'; ?>
