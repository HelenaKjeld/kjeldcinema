<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/News.php';
require_once __DIR__ . '/../../includes/ImageResizer.php';
include '../../components/header.php';

$newsObj = new News();

if (isset($_POST['addNews'])) {

    $bannerRel = ''; // relative path saved to DB

    if (!empty($_FILES['BannerImg']['tmp_name']) && is_uploaded_file($_FILES['BannerImg']['tmp_name'])) {

        $tmpPath      = $_FILES['BannerImg']['tmp_name'];
        $maxSizeBytes = 5 * 1024 * 1024; // 5MB

        if ($_FILES['BannerImg']['size'] > $maxSizeBytes) {
            echo "<p class='text-red-600 text-center mt-4'>Banner image is too large (max 5MB).</p>";
        } elseif ($_FILES['BannerImg']['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-red-600 text-center mt-4'>Upload error code: " . (int)$_FILES['BannerImg']['error'] . "</p>";
        } else {
            $imageInfo = @getimagesize($tmpPath);
            if ($imageInfo === false) {
                echo "<p class='text-red-600 text-center mt-4'>Invalid image file.</p>";
            } else {
                $imageType = $imageInfo[2];

                if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                    echo "<p class='text-red-600 text-center mt-4'>Only JPEG and PNG banner images are allowed.</p>";
                } else {
                    $extension   = ($imageType === IMAGETYPE_JPEG) ? '.jpg' : '.png';
                    $relativeDir = 'banners/';
                    $absoluteDir = __DIR__ . '/../../' . $relativeDir;

                    if (!is_dir($absoluteDir)) {
                        mkdir($absoluteDir, 0755, true);
                    }

                    $filename     = (function_exists('guidv4') ? guidv4() : bin2hex(random_bytes(16))) . $extension;
                    $relativePath = $relativeDir . $filename;
                    $absolutePath = $absoluteDir . $filename;

                    if (!move_uploaded_file($tmpPath, $absolutePath)) {
                        echo "<p class='text-red-600 text-center mt-4'>Failed to move uploaded file.</p>";
                    } else {
                        try {
                            $resizer = new ImageResizer();
                            $resizer->load($absolutePath);
                            // Resize + pad to standard banner size
                            //$resizer->resizeAndPad(1200, 400); // or adjust as needed ,1200, 400 for wide banner
                            $resizer->save($absolutePath, $imageType, 85);

                            $bannerRel = $relativePath;
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

    // Create the news row
    $newsObj->create([
        'Titel'       => $_POST['Titel'],
        'Text'        => $_POST['Text'],
        'BannerImg'   => $bannerRel,
        'ReleaseDate' => $_POST['ReleaseDate'],
    ]);

    echo "<p class='text-green-600 text-center mt-4'>News added!</p>";
    // Or redirect:
    // header("Location: news_page.php");
    // exit;
}
?>

<a href="news_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">Back</button>
</a>

<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Add News</h2>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" name="Titel" placeholder="Title" class="border p-2 rounded w-full text-slate-800" required>
        <input type="date" name="ReleaseDate" class="border p-2 rounded w-full text-slate-800" required>

        <div class="md:col-span-2">
            <textarea name="Text" rows="5" placeholder="Text" class="border p-2 rounded w-full text-slate-800" required></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Banner Image (optional)</label>
            <input type="file" name="BannerImg" accept="image/*" class="border p-2 rounded w-full text-slate-800">
        </div>

        <button type="submit" name="addNews" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded md:col-span-2 w-max">Add News</button>
    </form>
</div>

<?php include '../../components/footer.php'; ?>
