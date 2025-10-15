<?php
include '../../includes/functions.php';
?>
<?php
require_once __DIR__ . '/../../includes/connection.php';
$db = dbCon(); // this creates the PDO object
?>


<?php
if (isset($_POST['addMovie'])) {


    if (($_FILES['Poster']['type'] == "image/jpeg") || ($_FILES['Poster']['type'] == "image/png")) {
        if ($_FILES['Poster']['size'] < 2000000000) {
            if ($_FILES['Poster']['error'] > 0) {
                echo "oh NO!!!!!";
            } else {
                $newfilename = "posters/" . guidv4();
                move_uploaded_file(
                    $_FILES['Poster']['tmp_name'],
                    "../../" . $newfilename
                );

                $sql = "INSERT INTO Movie (Titel, Description, Poster, ageRating, Duration)
          VALUES (:Titel, :Description, :Poster, :ageRating, :Duration)";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':Titel' => $_POST['Titel'],
                    ':Description' => $_POST['Description'],
                    ':Poster' =>  $newfilename,
                    ':ageRating' => $_POST['ageRating'],
                    ':Duration' => $_POST['Duration']
                ]);
                echo "<p class='text-green-600'> Movie added successfully!</p>";
                redirect_to("movies_page.php");
            }
        } else {
            echo "<p class='text-red-600'> File size too large!</p>";
        }
    } else {
        echo "<p class='text-red-600'> Invalid file type!</p>";
    }
}
?>

<?php
include '../../components/header.php';
?>
<a href="movies_page.php"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button></a>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6"> Manage Movies</h2>
    <form action="" method="POST" class="bg-white p-6 rounded-lg shadow mb-8" enctype="multipart/form-data">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Add New Movie</h3>
        <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3 text-slate-800" required>
        <textarea name="Description" placeholder="Description" class="border p-2 w-full mb-3 text-slate-800" required></textarea>
        <input type="file" name="Poster" placeholder="Poster image" class=" p-1 w-full mb-3 text-slate-800">
        <input type="number" name="ageRating" placeholder="Age Rating" class="border p-2 w-full mb-3 text-slate-800" required>
        <input type="number" name="Duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-3 text-slate-800" required>
        <button type="submit" name="addMovie" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">Add Movie</button>
    </form>
</div>
