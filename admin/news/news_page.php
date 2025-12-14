<?php
include '../../includes/functions.php'; // guidv4, politi, etc.
require_once __DIR__ . '/../../OOP/classes/News.php';
require_once __DIR__ . '/../../includes/ImageResizer.php';
include '../../components/header.php';

$newsObj = new News();

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $newsObj->delete($id);
    echo "<p class='text-red-600 text-center mt-4'>News #{$id} deleted.</p>";
}

// Update (with optional new image)
if (isset($_POST['updateNews'])) {
    $id = (int)$_POST['NewsID'];

    // start with old banner path
    $bannerPath = $_POST['oldBanner'] ?? '';

    // if new file uploaded
    if (!empty($_FILES['BannerImg']['tmp_name']) && is_uploaded_file($_FILES['BannerImg']['tmp_name'])) {

        $tmpPath      = $_FILES['BannerImg']['tmp_name'];
        $maxSizeBytes = 5 * 1024 * 1024; // 5MB limit

        if ($_FILES['BannerImg']['size'] > $maxSizeBytes) {
            echo "<p class='text-red-600 text-center mt-4'>Banner image is too large (max 5MB).</p>";
        } elseif ($_FILES['BannerImg']['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-red-600 text-center mt-4'>Upload error code: " . (int)$_FILES['BannerImg']['error'] . "</p>";
        } else {
            $imageInfo = @getimagesize($tmpPath);
            if ($imageInfo === false) {
                echo "<p class='text-red-600 text-center mt-4'>Invalid image file.</p>";
            } else {
                $imageType = $imageInfo[2]; // IMAGETYPE_*

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
                            // Wide banner shape, adjust if you like
                            //$resizer->resizeAndPad(1200, 400);
                            $resizer->save($absolutePath, $imageType, 85);

                            // Delete old banner file if it existed
                            if (!empty($bannerPath)) {
                                $oldAbs = __DIR__ . '/../../' . $bannerPath;
                                if (is_file($oldAbs)) {
                                    @unlink($oldAbs);
                                }
                            }

                            $bannerPath = $relativePath;
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

    // Update DB row
    $newsObj->updateById($id, [
        'Titel'       => $_POST['Titel'],
        'Text'        => $_POST['Text'],
        'BannerImg'   => $bannerPath,
        'ReleaseDate' => $_POST['ReleaseDate'],
    ]);

    echo "<p class='text-green-600 text-center mt-4'>News #{$id} updated.</p>";
}

$all = $newsObj->getAll();
?>

<a href="../admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">Back</button>
</a>

<div class="flex justify-center">
    <a href="add_news_page.php">
        <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-slate-800 transition text-[30px]">ADD NEWS</button>
    </a>
</div>

<div class="p-6">
    <h3 class="text-xl font-semibold mb-4 mt-8">All News</h3>
    <table class="w-full bg-white border-collapse shadow rounded-lg">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="text-slate-800 p-3">ID</th>
                <th class="text-slate-800 p-3">Title</th>
                <th class="text-slate-800 p-3">Text</th>
                <th class="text-slate-800 p-3">Banner</th>
                <th class="text-slate-800 p-3">Release Date</th>
                <th class="text-slate-800 p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all as $row): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="text-slate-800 p-3"><?= $row['NewsID'] ?></td>
                    <td class="text-slate-800 p-3"><?= politi($row['Titel']) ?></td>
                    <td class=" text-slate-800 p-3"><?= nl2br(politi($row['Text'])) ?></td>
                    <td class="p-3">
                        <?php if (!empty($row['BannerImg'])): ?>
                            <img src="/<?= politi($row['BannerImg']) ?>" class="w-32 h-16 object-cover rounded" alt="">
                        <?php else: ?>
                            <span class="text-gray-400 italic">No image</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-slate-800 p-3"><?= politi($row['ReleaseDate']) ?></td>
                    <td class="p-3 flex gap-2">
                        <button onclick="toggleEdit(<?= $row['NewsID'] ?>)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Edit</button>
                        <a href="?delete=<?= $row['NewsID'] ?>" onclick="return confirm('Delete this news?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                    </td>
                </tr>

                <!-- Inline Edit Form -->
                <tr id="editRow<?= $row['NewsID'] ?>" class="hidden bg-amber-50">
                    <td colspan="6" class="p-4">
                        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="hidden" name="NewsID" value="<?= $row['NewsID'] ?>">
                            <input type="hidden" name="oldBanner" value="<?= politi($row['BannerImg']) ?>">

                            <input type="text" name="Titel" value="<?= politi($row['Titel']) ?>" class="border p-2 rounded w-full text-slate-800" required>
                            <input type="date" name="ReleaseDate" value="<?= politi($row['ReleaseDate']) ?>" class="border p-2 rounded w-full text-slate-800" required>

                            <textarea name="Text" class="border p-2 rounded w-full col-span-2 text-slate-800" rows="4" placeholder="Text"><?= htmlspecialchars($row['Text']) ?></textarea>

                            <div class="col-span-2">
                                <label class="block text-sm text-gray-700">Change Banner:</label>
                                <input type="file" name="BannerImg" accept="image/*" class="border p-2 rounded w-full text-slate-800">
                                <?php if (!empty($row['BannerImg'])): ?>
                                    <img src="/<?= politi($row['BannerImg']) ?>" class="w-32 mt-2 rounded" alt="">
                                <?php endif; ?>
                            </div>

                            <button type="submit" name="updateNews" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded col-span-2 w-max">Save Changes</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($all)): ?>
                <tr><td colspan="6" class="p-6 text-center text-gray-500 italic">No news yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function toggleEdit(id){
    document.getElementById('editRow'+id).classList.toggle('hidden');
}
</script>

<?php include '../../components/footer.php'; ?>
