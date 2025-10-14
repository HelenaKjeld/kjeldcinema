<?php
include 'includes/functions.php';
?>
<?php
require_once __DIR__ . '/includes/connection.php';
$db = dbCon(); // this creates the PDO object

?>
<?php include 'components/header.php'; ?>

<a href="admin_panel_page"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button></a>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6"> Manage Movies</h2>

    <!-- Add Movie Form -->
    <form action="movies_create.php" method="POST" class="bg-white p-6 rounded-lg shadow mb-8" enctype="multipart/form-data">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Add New Movie</h3>
        <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3" required>
        <textarea name="Description" placeholder="Description" class="border p-2 w-full mb-3" required></textarea>
        <input type="file" name="Poster" placeholder="Poster image" class="border p-2 w-full mb-3">
        <input type="number" name="ageRating" placeholder="Age Rating" class="border p-2 w-full mb-3" required>
        <input type="number" name="Duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-3" required>
        <input type="" name=>
        <button type="submit" name="addMovie" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">Add Movie</button>
    </form>


    <!-- Display Existing Movies -->
    <h3 class="text-xl font-semibold mb-4 mt-8 ">All Movies</h3>
    <table class="w-full bg-white border-collapse shadow rounded-lg">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="p-3 text-slate-800">ID</th>
                <th class="p-3 text-slate-800">Title</th>
                <th class="p-3 text-slate-800">Age</th>
                <th class="p-3 text-slate-800">Duration</th>
                <th class="p-3 text-slate-800">Poster</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $db->query("SELECT * FROM Movie");
            foreach ($stmt as $row) {
                echo "<tr class='border-b hover:bg-gray-50'>
                <td class='p-3 text-slate-800'>{$row['MovieID']}</td>
                <td class='p-3 text-slate-800'>" . htmlspecialchars($row['Titel']) . "</td>
                <td class='p-3 text-slate-800'>{$row['ageRating']}</td>
                <td class='p-3 text-slate-800'>{$row['Duration']} min</td>
                <td class='p-3 text-slate-800'><img src='{$row['Poster']}' alt='poster' class='w-12 h-auto rounded'></td>
              </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'components/footer.php';
?>