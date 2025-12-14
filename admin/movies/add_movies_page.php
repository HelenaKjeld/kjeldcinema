<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/Database.php';
require_once __DIR__ . '/../../includes/ImageResizer.php';

if (isset($_POST['addMovie'])) {

    if (!isset($_FILES['Poster']) || empty($_FILES['Poster']['tmp_name'])) {
        echo "<p class='text-red-600 text-center mt-4'>Poster image is required.</p>";
    } else {
        $tmpPath = $_FILES['Poster']['tmp_name'];

        // Basic file size check (max ~5MB; adjust if you want)
        $maxSizeBytes = 5 * 1024 * 1024;
        if ($_FILES['Poster']['size'] > $maxSizeBytes) {
            echo "<p class='text-red-600 text-center mt-4'>File size too large (max 5MB).</p>";
        } elseif ($_FILES['Poster']['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-red-600 text-center mt-4'>Upload error code: " . (int) $_FILES['Poster']['error'] . "</p>";
        } else {
            // Validate as image using getimagesize
            $imageInfo = @getimagesize($tmpPath);
            if ($imageInfo === false) {
                echo "<p class='text-red-600 text-center mt-4'>Invalid image file.</p>";
            } else {
                $imageType = $imageInfo[2]; // IMAGETYPE_*

                if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                    echo "<p class='text-red-600 text-center mt-4'>Only JPEG and PNG posters are allowed.</p>";
                } else {
                    // Decide extension based on actual image type
                    $extension = $imageType === IMAGETYPE_JPEG ? '.jpg' : '.png';

                    // Store posters in /posters  (relative to project root)
                    $relativeDir = 'posters/';
                    $absoluteDir = __DIR__ . '/../../' . $relativeDir;

                    if (!is_dir($absoluteDir)) {
                        mkdir($absoluteDir, 0755, true);
                    }

                    $filename     = guidv4() . $extension;
                    $relativePath = $relativeDir . $filename;    // goes in DB
                    $absolutePath = $absoluteDir . $filename;    // full path

                    if (!move_uploaded_file($tmpPath, $absolutePath)) {
                        echo "<p class='text-red-600 text-center mt-4'>Failed to move uploaded file.</p>";
                    } else {
                        try {
                            $resizer = new ImageResizer();
                            $resizer->load($absolutePath);
                            // Uniform poster shape
                            $resizer->fitToPosterBox();
                            $resizer->save($absolutePath, $imageType, 85);

                            // Insert movie row
                            $sql = "INSERT INTO movie (Titel, Description, Poster, ageRating, Duration)
                                    VALUES (:Titel, :Description, :Poster, :ageRating, :Duration)";

                            $database = Database::getInstance();
                            $stmt = $database->getConnection()->prepare($sql);
                            $stmt->execute([
                                ':Titel'       => $_POST['Titel'],
                                ':Description' => $_POST['Description'],
                                ':Poster'      => $relativePath,
                                ':ageRating'   => $_POST['ageRating'],
                                ':Duration'    => $_POST['Duration']
                            ]);

                            redirect_to("movies_page.php");
                        } catch (Throwable $e) {
                            if (is_file($absolutePath)) {
                                @unlink($absolutePath);
                            }
                            echo "<p class='text-red-600 text-center mt-4'>Image processing failed: "
                                . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
                                . "</p>";
                        }
                    }
                }
            }
        }
    }
}

include '../../components/header.php';
?>
<a href="movies_page.php">
    <button
        class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Manage Movies</h2>
    <form action="" method="POST" class="bg-white p-6 rounded-lg shadow mb-8" enctype="multipart/form-data">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Add New Movie</h3>
        <input type="text" name="Titel" placeholder="Title" class="border p-2 w-full mb-3 text-slate-800" required>
        <textarea name="Description" placeholder="Description"
                  class="border p-2 w-full mb-3 text-slate-800" required></textarea>
        <input type="file" name="Poster" class="p-1 w-full mb-3 text-slate-800" accept="image/*" required>
        <input type="number" name="ageRating" placeholder="Age Rating"
               class="border p-2 w-full mb-3 text-slate-800" required>
        <input type="number" name="Duration" placeholder="Duration (minutes)"
               class="border p-2 w-full mb-3 text-slate-800" required>
        <button type="submit" name="addMovie"
                class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded">
            Add Movie
        </button>
    </form>
</div>
