<?php
include '../../includes/functions.php';
include '../../components/header.php';
require_once __DIR__ . '/../../OOP/classes/Movie.php';

$movie = new Movie();


// Handle Delete Request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    if ($movie->delete($deleteId)) {
        echo "<p class='text-red-600 text-center mt-4'>Movie deleted successfully.</p>";
    } else {
        echo "<p class='text-red-600 text-center mt-4'>Error deleting movie.</p>";
    }
}


// Handle Update Request
if (isset($_POST['updateMovie'])) {
    $movieId = $_POST['MovieID'];
    $posterPath = $_POST['oldPoster']; // Default old poster path

    // Handle new poster upload
    if (!empty($_FILES['Poster']['tmp_name'])) {
        $uploadDir = "../../posters/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = guidv4();
        $targetFile = $uploadDir . $fileName;
        move_uploaded_file($_FILES['Poster']['tmp_name'], $targetFile);
        $posterPath = "posters/" . $fileName;
    }

    $updateData = [
        'Titel' => $_POST['Titel'],
        'Description' => $_POST['Description'],
        'Poster' => $posterPath,
        'ageRating' => $_POST['ageRating'],
        'Duration' => $_POST['Duration']
    ];

    if ($movie->update($movieId, $updateData)) {
        echo "<p class='text-green-600 text-center mt-4'>Movie updated successfully.</p>";
    } else {
        echo "<p class='text-red-600 text-center mt-4'>Error updating movie.</p>";
    }
}


// Fetch All Movies
$movies = $movie->all();
?>

<a href="/admin/admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="flex justify-center">
    <a href="add_movies_page.php">
        <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-slate-800 transition text-[30px]">
            ADD MOVIE
        </button>
    </a>
</div>

<div class="p-6">
    <h3 class="text-xl font-semibold mb-4 mt-8">All Movies</h3>
    <table class="w-full bg-white border-collapse shadow rounded-lg">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="p-3 text-slate-800">ID</th>
                <th class="p-3 text-slate-800">Title</th>
                <th class="p-3 text-slate-800">Description</th>
                <th class="p-3 text-slate-800">Age</th>
                <th class="p-3 text-slate-800">Duration</th>
                <th class="p-3 text-slate-800">Poster</th>
                <th class="p-3 text-slate-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $row): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-slate-800"><?= $row['MovieID'] ?></td>
                    <td class="p-3 text-slate-800"><?= politi($row['Titel']) ?></td>
                    <td class="p-3 text-slate-800"><?= politi($row['Description']) ?></td>
                    <td class="p-3 text-slate-800"><?= $row['ageRating'] ?></td>
                    <td class="p-3 text-slate-800"><?= $row['Duration'] ?> min</td>
                    <td class="p-3 text-slate-800">
                        <?php if (!empty($row['Poster'])): ?>
                            <img src="/<?= politi($row['Poster']) ?>" alt="poster" class="w-12 h-auto rounded">
                        <?php else: ?>
                            <span class="text-gray-400 italic">No poster</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3 text-slate-800 flex gap-2">
                        <button onclick="toggleEdit(<?= $row['MovieID'] ?>)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Edit</button>
                        <a href="?delete=<?= $row['MovieID'] ?>" onclick="return confirm('Are you sure you want to delete this movie?');" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                    </td>
                </tr>

                <!-- Inline Edit Form -->
                <tr id="editRow<?= $row['MovieID'] ?>" class="hidden bg-amber-50">
                    <td colspan="6" class="p-4">
                        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="hidden" name="MovieID" value="<?= $row['MovieID'] ?>">
                            <input type="hidden" name="oldPoster" value="<?= politi($row['Poster']) ?>">
                            <input type="text" name="Titel" value="<?= politi($row['Titel']) ?>" class="border p-2 rounded w-full text-slate-800" required>
                            <input type="number" name="ageRating" value="<?= $row['ageRating'] ?>" class="border p-2 rounded w-full text-slate-800">
                            <input type="number" name="Duration" value="<?= $row['Duration'] ?>" class="border p-2 rounded w-full text-slate-800">
                            <textarea name="Description" class="border p-2 rounded w-full col-span-2 text-slate-800"><?= politi($row['Description']) ?></textarea>

                            <div class="col-span-2">
                                <label class="block text-sm text-gray-700">Change Poster:</label>
                                <input type="file" name="Poster" accept="image/*" class="border p-2 rounded w-full text-slate-800">
                                <?php if (!empty($row['Poster'])): ?>
                                    <img src="/<?= politi($row['Poster']) ?>" alt="poster" class="w-16 mt-2 rounded">
                                <?php endif; ?>
                            </div>

                            <button type="submit" name="updateMovie" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded col-span-2 w-max">Save Changes</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleEdit(id) {
        const row = document.getElementById('editRow' + id);
        row.classList.toggle('hidden');
    }
</script>

<?php include '../../components/footer.php'; ?>