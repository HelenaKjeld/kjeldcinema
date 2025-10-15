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
<div class="flex justify-center">
    <a href="add_movies_page.php"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-slate-800 transition text-[30px]">
            ADD MOVIE
        </button></a>
</div>

<div class="p-6">
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