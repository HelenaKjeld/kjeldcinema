
<?php
include 'functions/functions.php';
?>
<?php
require_once __DIR__ . '/includes/connection.php';
$db = dbCon(); // this creates the PDO object

?>
<?php include 'components/header.php'; ?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6"> Manage Movies</h2>

    <!-- Add Movie Form -->
    <form action="" method="POST" class="bg-white p-6 rounded-lg shadow mb-8" enctype="multipart/form-data">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Add New Movie</h3>
        <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3" required>
        <textarea name="Description" placeholder="Description" class="border p-2 w-full mb-3" required></textarea>
        <input type="file" name="Poster" placeholder="Poster image" class="border p-2 w-full mb-3">
        <input type="number" name="ageRating" placeholder="Age Rating" class="border p-2 w-full mb-3" required>
        <input type="number" name="Duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-3" required>
        <button type="submit" name="addMovie" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">Add Movie</button>
    </form>

    <?php
    if (isset($_POST['addMovie'])) {
        if (($_FILES['imagefile']['type'] == "image/jpeg") || ($_FILES['imagefile']['type'] == "image/png")) {
            if ($_FILES['imagefile']['size'] < 2000000000) {
                if ($_FILES['imagefile']['error'] > 0) {
                    echo "oh NO!!!!!";
                } else {

                    move_uploaded_file(
                        $_FILES['imagefile']['tmp_name'],
                        "img/" . $_FILES['imagefile']['name']
                    );
                }
            } else {
                echo "<p class='text-red-600'> File size too large!</p>";
            }
        } else {
            echo "<p class='text-red-600'> Invalid file type!</p>";
        }

        $sql = "INSERT INTO Movie (Titel, Description, Poster, ageRating, Duration)
          VALUES (:Titel, :Description, :Poster, :ageRating, :Duration)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':Titel' => $_POST['Titel'],
            ':Description' => $_POST['Description'],
            ':Poster' => $_POST['Poster'],
            ':ageRating' => $_POST['ageRating'],
            ':Duration' => $_POST['Duration']
        ]);
        echo "<p class='text-green-600'> Movie added successfully!</p>";
    }
    ?>

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
                <td class='p-3'>{$row['MovieID']}</td>
                <td class='p-3'>" . htmlspecialchars($row['Titel']) . "</td>
                <td class='p-3'>{$row['ageRating']}</td>
                <td class='p-3'>{$row['Duration']} min</td>
                <td class='p-3'><img src='{$row['Poster']}' alt='poster' class='w-12 h-auto rounded'></td>
              </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'components/footer.php';
?>