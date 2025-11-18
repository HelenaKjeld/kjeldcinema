<?php
require_once __DIR__ . '/../../OOP/classes/Showing.php';
require_once __DIR__ . '/../../OOP/classes/Movie.php';
require_once __DIR__ . '/../../OOP/classes/Showroom.php';
include '../../components/header.php';

$showing = new Showing();
$movie = new Movie();
$showroom = new Showroom();

// Handle add
if (isset($_POST['addShowing'])) {
    $showing->create([
        'DATE' => $_POST['DATE'],
         'Time' => $_POST['Time'],
        'Price' => $_POST['Price'],
        'MovieID' => $_POST['MovieID'],
        'ShowroomID' => $_POST['ShowroomID']
    ]);
    echo "<p class='text-green-600 text-center mt-4'>Showing added successfully!</p>";
}

// Handle delete
if (isset($_GET['delete'])) {
    $showing->delete($_GET['delete']);
    echo "<p class='text-red-600 text-center mt-4'>Showing deleted successfully!</p>";
}

$allShowings = $showing->getAllWithDetails();
$movies = $movie->all();
$showrooms = $showroom->all();
?>

<a href="/admin/admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-center">Manage Schedules</h2>

    <!-- Add Form -->
    <form method="POST" class="bg-white p-6 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="date" name="DATE" class="border p-2 rounded text-slate-800" required>
         <input type="time" name="Time" class="border p-2 rounded text-slate-800" required> 
        <input type="number" name="Price" placeholder="Price" step="0.01" class="border p-2 rounded text-slate-800" required>

        <select name="MovieID" class="border p-2 rounded text-slate-800" required>
            <option value="">Select Movie</option>
            <?php foreach ($movies as $m): ?>
                <option value="<?= $m['MovieID'] ?>"><?= politi($m['Titel']) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="ShowroomID" class="border p-2 rounded text-slate-800" required>
            <option value="">Select Showroom</option>
            <?php foreach ($showrooms as $s): ?>
                <option value="<?= $s['ShowroomID'] ?>"><?= politi($s['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="addShowing" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded col-span-2">
            Add Showing
        </button>
    </form>

    <!-- Table -->
    <table class="w-full bg-white border-collapse shadow rounded-lg">
        <thead class="bg-gray-200 text-left">
            <tr>     
                <th class="p-3 text-slate-800">Date</th>
                <th class="p-3 text-slate-800">Time</th>
                <th class="p-3 text-slate-800">Price</th>
                <th class="p-3 text-slate-800">Movie</th>
                <th class="p-3 text-slate-800">Showroom</th>
                <th class="p-3 text-slate-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allShowings as $sh): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-slate-800"><?= politi($sh['DATE']) ?></td>
                    <td class="p-3 text-slate-800"><?= politi($sh['Time']) ?></td>
                    <td class="p-3 text-slate-800"><?= politi($sh['Price']) ?> DKK</td>
                    <td class="p-3 text-slate-800"><?= politi($sh['MovieTitle']) ?></td>
                    <td class="p-3 text-slate-800"><?= politi($sh['ShowroomName']) ?></td>
                    <td class="p-3 text-slate-800">
                        <a href="?delete=<?= $sh['ShowingID'] ?>"
                           onclick="return confirm('Are you sure you want to delete this showing?');"
                           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../components/footer.php'; ?>
