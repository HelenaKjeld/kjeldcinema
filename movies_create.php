<?php
include 'includes/functions.php';
?>
<?php
require_once __DIR__ . '/includes/connection.php';
$db = dbCon(); // this creates the PDO object


if (isset($_POST['addMovie'])) {


    if (($_FILES['Poster']['type'] == "image/jpeg") || ($_FILES['Poster']['type'] == "image/png")) {
        if ($_FILES['Poster']['size'] < 2000000000) {
            if ($_FILES['Poster']['error'] > 0) {
                echo "oh NO!!!!!";
            } else {
                $newfilename = "posters/" . guidv4();
                move_uploaded_file(
                    $_FILES['Poster']['tmp_name'],
                    $newfilename
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
                redirect_to("movies_management_page.php");
            }
        } else {
            echo "<p class='text-red-600'> File size too large!</p>";
        }
    } else {
        echo "<p class='text-red-600'> Invalid file type!</p>";
    }
}
?>