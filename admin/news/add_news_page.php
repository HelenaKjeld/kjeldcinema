<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/News.php';
include '../../components/header.php';

$newsObj = new News();

if (isset($_POST['addNews'])) {

    $bannerRel = ''; // relative path saved to DB

    if (!empty($_FILES['BannerImg']['tmp_name']) && is_uploaded_file($_FILES['BannerImg']['tmp_name'])) {
        $allowed = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/webp' => '.webp'];
        $mime = mime_content_type($_FILES['BannerImg']['tmp_name']);
        if (isset($allowed[$mime])) {
            $ext = $allowed[$mime];
            $dirFs = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR . 'banners' . DIRECTORY_SEPARATOR;
            if (!is_dir($dirFs)) {
                mkdir($dirFs, 0777, true);
            }
            $filename = (function_exists('guidv4') ? guidv4() : bin2hex(random_bytes(16))) . $ext;
            $fullPath = $dirFs . $filename;

            if (move_uploaded_file($_FILES['BannerImg']['tmp_name'], $fullPath)) {
                $bannerRel = "banners/" . $filename;
            }
        }
    }

    $newsObj->create([
        'Titel'       => $_POST['Titel'],
        'Text'        => $_POST['Text'],
        'BannerImg'   => $bannerRel,
        'ReleaseDate' => $_POST['ReleaseDate'],
    ]);

    echo "<p class='text-green-600 text-center mt-4'>News added!</p>";
    // Optionally redirect: header("Location: news_page.php"); exit;
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
