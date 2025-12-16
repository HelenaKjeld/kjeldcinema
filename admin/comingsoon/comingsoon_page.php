<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/ComingSoon.php';
require_once __DIR__ . '/../../OOP/classes/Movie.php';
require_once __DIR__ . '/../../includes/session.php';
require_admin();  
$comingSoon = new ComingSoon();
$movie = new Movie();

include '../../components/header.php';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComingSoon'])) {
    $comingSoon->add($_POST['MovieID'], $_POST['ReleaseDate']);
    echo "<p class='text-green-600 text-center mt-4'>Coming soon movie added!</p>";
}

// Handle Delete
if (isset($_GET['delete'])) {
    $comingSoon->delete($_GET['delete']);
    echo "<p class='text-red-600 text-center mt-4'>Coming soon movie deleted!</p>";
}

$entries = $comingSoon->getAllWithMovies();
$availableMovies = $comingSoon->getAvailableMovies();
?>

<a href="/admin/admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Coming Soon Movies</h2>

    <!-- Add New Coming Soon -->
    <div class="bg-amber-50 p-6 rounded-lg shadow mb-8">
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Select Movie</label>
                <select name="MovieID" required class="border p-2 rounded w-full text-slate-800">
                    <option value="">-- Choose a movie --</option>
                    <?php foreach ($availableMovies as $m): ?>
                        <option value="<?= $m['MovieID'] ?>"><?= politi($m['Titel']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Release Date</label>
                <input type="date" name="ReleaseDate" required class="border p-2 rounded w-full text-slate-800">
            </div>
            <button type="submit" name="addComingSoon" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded w-max">
                Add Coming Soon
            </button>
        </form>
    </div>

    <!-- Display All -->
    <?php if ($entries): ?>
        <table class="w-full bg-white border-collapse shadow rounded-lg">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="p-3 text-slate-800">Poster</th>
                    <th class="p-3 text-slate-800">Title</th>
                    <th class="p-3 text-slate-800">Release Date</th>
                    <th class="p-3 text-slate-800">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $row): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><img src="/<?= politi($row['Poster']) ?>" class="w-16 h-auto rounded"></td>
                        <td class="p-3 text-slate-800"><?= politi($row['Titel']) ?></td>
                        <td class="p-3 text-slate-800"><?= politi($row['ReleaseDate']) ?></td>
                        <td class="p-3">
                            <a href="?delete=<?= $row['ComingSoonID'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this entry?');"
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-gray-500 italic mt-6">No coming soon movies yet.</p>
    <?php endif; ?>
</div>

<?php include '../../components/footer.php'; ?>
