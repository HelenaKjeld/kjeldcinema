<?php 
include 'includes/functions.php';
require_once __DIR__ . '/includes/connection.php';
$db = dbCon();
include 'components/header.php';

//  Handle Delete Request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM Movie WHERE MovieID = :id");
    $stmt->execute([':id' => $deleteId]);
    echo "<p class='text-red-600 text-center mt-4'> Movie deleted successfully.</p>";
}

//  Handle Update Request (with image upload)
if (isset($_POST['updateMovie'])) {
    $movieId = $_POST['MovieID'];

    // Handle new poster upload
    $posterPath = $_POST['oldPoster']; // default to old poster

    if (!empty($_FILES['Poster']['tmp_name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES['Poster']['name']);
        $targetFile = $uploadDir . $fileName;
        move_uploaded_file($_FILES['Poster']['tmp_name'], $targetFile);
        $posterPath = $targetFile;
    }

    $stmt = $db->prepare("UPDATE Movie 
                          SET Titel=:t, Description=:d, Poster=:p, ageRating=:a, Duration=:du 
                          WHERE MovieID=:id");
    $stmt->execute([
        ':t' => $_POST['Titel'],
        ':d' => $_POST['Description'],
        ':p' => $posterPath,
        ':a' => $_POST['ageRating'],
        ':du' => $_POST['Duration'],
        ':id' => $movieId
    ]);

    echo "<p class='text-green-600 text-center mt-4'> Movie updated successfully.</p>";
}
?>

<a href="admin_panel_page">
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
                <th class="p-3 text-slate-800">Age</th>
                <th class="p-3 text-slate-800">Duration</th>
                <th class="p-3 text-slate-800">Poster</th>
                <th class="p-3 text-slate-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $db->query("SELECT * FROM Movie ORDER BY MovieID DESC");
            foreach ($stmt as $row):
            ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-slate-800"><?= $row['MovieID'] ?></td>
                    <td class="p-3 text-slate-800"><?= htmlspecialchars($row['Titel']) ?></td>
                    <td class="p-3 text-slate-800"><?= $row['ageRating'] ?></td>
                    <td class="p-3 text-slate-800"><?= $row['Duration'] ?> min</td>
                    <td class="p-3 text-slate-800">
                        <?php if ($row['Poster']): ?>
                            <img src="<?= htmlspecialchars($row['Poster']) ?>" alt="poster" class="w-12 h-auto rounded">
                        <?php else: ?>
                            <span class="text-gray-400 italic">No poster</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3 text-slate-800 flex gap-2">
                        <button onclick="toggleEdit(<?= $row['MovieID'] ?>)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Edit</button>
                        <a href="?delete=<?= $row['MovieID'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this movie?');"
                           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                    </td>
                </tr>

                <!-- Inline Edit Form -->
                <tr id="editRow<?= $row['MovieID'] ?>" class="hidden bg-amber-50">
                    <td colspan="6" class="p-4">
                        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="hidden" name="MovieID" value="<?= $row['MovieID'] ?>">
                            <input type="hidden" name="oldPoster" value="<?= htmlspecialchars($row['Poster']) ?>">

                            <input type="text" name="Titel" value="<?= htmlspecialchars($row['Titel']) ?>" class="border p-2 rounded w-full" required>
                            <input type="number" name="ageRating" value="<?= $row['ageRating'] ?>" class="border p-2 rounded w-full">
                            <input type="number" name="Duration" value="<?= $row['Duration'] ?>" class="border p-2 rounded w-full">
                            <textarea name="Description" class="border p-2 rounded w-full col-span-2" placeholder="Description"><?= htmlspecialchars($row['Description']) ?></textarea>

                            <div class="col-span-2">
                                <label class="block text-sm text-gray-700">Change Poster:</label>
                                <input type="file" name="Poster" accept="image/*" class="border p-2 rounded w-full">
                                <?php if ($row['Poster']): ?>
                                    <img src="<?= htmlspecialchars($row['Poster']) ?>" alt="poster" class="w-16 mt-2 rounded">
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

<?php include 'components/footer.php'; ?>
