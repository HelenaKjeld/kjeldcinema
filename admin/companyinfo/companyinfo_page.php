<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/CompanyInfo.php';
require_once __DIR__ . '/../../includes/ImageResizer.php';
include '../../components/header.php';

$companyModel = new CompanyInfo();

if (isset($_GET['delete'])) {
    $companyModel->deleteCompanyInfo((int)$_GET['delete']);
    echo "<p class='text-red-600 text-center mt-4'>Company info deleted successfully.</p>";
}

// Handle add/update
if (isset($_POST['saveCompany'])) {
    // Start with old logo path (if any)
    $logoPath = $_POST['oldLogo'] ?? '';

    // Handle new logo upload (optional)
    if (!empty($_FILES['Logo']['tmp_name']) && is_uploaded_file($_FILES['Logo']['tmp_name'])) {

        $tmpPath      = $_FILES['Logo']['tmp_name'];
        $maxSizeBytes = 5 * 1024 * 1024; // 5MB limit

        if ($_FILES['Logo']['size'] > $maxSizeBytes) {
            echo "<p class='text-red-600 text-center mt-4'>Logo file is too large (max 5MB).</p>";
        } elseif ($_FILES['Logo']['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-red-600 text-center mt-4'>Upload error code: " . (int)$_FILES['Logo']['error'] . "</p>";
        } else {
            $imageInfo = @getimagesize($tmpPath);
            if ($imageInfo === false) {
                echo "<p class='text-red-600 text-center mt-4'>Invalid image file.</p>";
            } else {
                $imageType = $imageInfo[2];


                if (!in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                    echo "<p class='text-red-600 text-center mt-4'>Only JPEG and PNG logo images are allowed.</p>";
                } else {
                    $extension   = ($imageType === IMAGETYPE_JPEG) ? '.jpg' : '.png';
                    $relativeDir = 'logo/';
                    $absoluteDir = __DIR__ . '/../../' . $relativeDir;

                    if (!is_dir($absoluteDir)) {
                        mkdir($absoluteDir, 0755, true);
                    }

                    $filename     = (function_exists('guidv4') ? guidv4() : bin2hex(random_bytes(16))) . $extension;
                    $relativePath = $relativeDir . $filename;
                    $absolutePath = $absoluteDir . $filename;

                    if (!move_uploaded_file($tmpPath, $absolutePath)) {
                        echo "<p class='text-red-600 text-center mt-4'>Failed to move uploaded logo file.</p>";
                    } else {
                        try {
                            $resizer = new ImageResizer();
                            $resizer->setMinimumSize(200, 200);
                            $resizer->load($absolutePath);

                            // Make it a neat square logo, e.g. 300x300
                            //$resizer->resizeAndPad(300, 300);
                            $resizer->save($absolutePath, $imageType, 90);

                            // Delete old logo file if one existed
                            if (!empty($logoPath)) {
                                $oldAbs = __DIR__ . '/../../' . $logoPath;
                                if (is_file($oldAbs)) {
                                    @unlink($oldAbs);
                                }
                            }

                            // Only update path if everything went fine
                            $logoPath = $relativePath;
                        } catch (Throwable $e) {
                            // Clean up broken upload
                            if (is_file($absolutePath)) {
                                @unlink($absolutePath);
                            }

                            echo "<p class='text-red-600 text-center mt-4'>Image processing failed: "
                                . politi($e->getMessage(), ENT_QUOTES, 'UTF-8')
                                . "</p>";
                            // On failure we keep old $logoPath (so you don't lose your existing logo)
                        }
                    }
                }
            }
        }
    }

    // Save company info (text + logo path)
    $result = $companyModel->saveCompanyInfo($_POST, $logoPath);
    if ($result === "updated") {
        echo "<p class='text-green-600 text-center mt-4'>Company info updated successfully!</p>";
    } else {
        echo "<p class='text-green-600 text-center mt-4'>Company info added successfully!</p>";
    }
}

// Fetch current company info
$info = $companyModel->getCompanyInfo();
?>

<a href="/admin/admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Company Information</h2>

    <?php if ($info): ?>
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex flex-col items-center mb-4">
                <?php if (!empty($info['Logo'])): ?>
                    <img src="/<?= politi($info['Logo']) ?>" alt="Company Logo" class="w-32 h-32 object-contain mb-3">
                <?php else: ?>
                    <div class="w-32 h-32 bg-gray-200 flex items-center justify-center text-gray-500 rounded mb-3">No Logo</div>
                <?php endif; ?>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-slate-800"><?= politi($info['Name']) ?></h3>
            <p class="mb-2 text-slate-700"><strong>Description:</strong> <?= nl2br(politi($info['Description'])) ?></p>
            <p class="mb-2 text-slate-700"><strong>Email:</strong> <?= politi($info['Email']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Phone:</strong> <?= politi($info['PhoneNumber']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Opening Hours:</strong> <?= politi($info['OpeningHours']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Address:</strong> <?= politi($info['Address']) ?></p>

            <!-- Social Links Display -->
            <div class="mt-4 border-t pt-4">
                <h4 class="font-semibold mb-2 text-slate-800">Social Media</h4>

                <?php if (!empty($info['Facebook'])): ?>
                    <p class="mb-1 text-slate-700">
                        <strong>Facebook:</strong>
                        <a href="<?= politi($info['Facebook']) ?>" target="_blank" class="text-blue-600 underline">
                            <?= politi($info['Facebook']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($info['Instagram'])): ?>
                    <p class="mb-1 text-slate-700">
                        <strong>Instagram:</strong>
                        <a href="<?= politi($info['Instagram']) ?>" target="_blank" class="text-blue-600 underline">
                            <?= politi($info['Instagram']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($info['Twitter'])): ?>
                    <p class="mb-1 text-slate-700">
                        <strong>Twitter:</strong>
                        <a href="<?= politi($info['Twitter']) ?>" target="_blank" class="text-blue-600 underline">
                            <?= politi($info['Twitter']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($info['Youtube'])): ?>
                    <p class="mb-1 text-slate-700">
                        <strong>Youtube:</strong>
                        <a href="<?= politi($info['Youtube']) ?>" target="_blank" class="text-blue-600 underline">
                            <?= politi($info['Youtube']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (empty($info['Facebook']) && empty($info['Instagram']) && empty($info['Twitter']) && empty($info['Youtube'])): ?>
                    <p class="text-gray-500 italic">No social media links added yet.</p>
                <?php endif; ?>
            </div>

            <div class="flex gap-4 mt-4">
                <button onclick="toggleEdit()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit</button>
                <a href="?delete=<?= $info['CompanyInfoID'] ?>"
                    onclick="return confirm('Are you sure you want to delete this info?');"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</a>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500 mb-6 italic">No company information found. Add below.</p>
    <?php endif; ?>

    <!-- Add / Edit Form -->
    <div id="editForm" class="<?= $info ? 'hidden' : '' ?> bg-amber-50 p-6 rounded-lg shadow">
        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
            <input type="text" name="Name" value="<?= politi($info['Name'] ?? '') ?>" placeholder="Company Name" class="border p-2 rounded w-full text-slate-800" required>
            <textarea name="Description" placeholder="Description" class="border p-2 rounded w-full text-slate-800"><?= politi($info['Description'] ?? '') ?></textarea>
            <input type="email" name="Email" value="<?= politi($info['Email'] ?? '') ?>" placeholder="Email" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="PhoneNumber" value="<?= politi($info['PhoneNumber'] ?? '') ?>" placeholder="Phone Number" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="OpeningHours" value="<?= politi($info['OpeningHours'] ?? '') ?>" placeholder="Opening Hours" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="Address" value="<?= politi($info['Address'] ?? '') ?>" placeholder="Address" class="border p-2 rounded w-full text-slate-800" required>

            <!-- Social Inputs -->
            <input type="text" name="Facebook" value="<?= politi($info['Facebook'] ?? '') ?>" placeholder="Facebook URL" class="border p-2 rounded w-full text-slate-800">
            <input type="text" name="Instagram" value="<?= politi($info['Instagram'] ?? '') ?>" placeholder="Instagram URL" class="border p-2 rounded w-full text-slate-800">
            <input type="text" name="Twitter" value="<?= politi($info['Twitter'] ?? '') ?>" placeholder="Twitter URL" class="border p-2 rounded w-full text-slate-800">
            <input type="text" name="Youtube" value="<?= politi($info['Youtube'] ?? '') ?>" placeholder="Youtube URL" class="border p-2 rounded w-full text-slate-800">

            <input type="hidden" name="oldLogo" value="<?= isset($info['Logo']) ? politi($info['Logo']) : '' ?>">

            <div>
                <label class="block text-gray-700 mb-1">Company Logo:</label>
                <input type="file" name="Logo" accept="image/*" class="border p-2 rounded w-full text-slate-800">
                <?php if (!empty($info['Logo'])): ?>
                    <img src="/<?= politi($info['Logo']) ?>" alt="Current Logo" class="w-20 mt-2 rounded">
                <?php endif; ?>
            </div>

            <button type="submit" name="saveCompany" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded w-max">Save</button>
        </form>
    </div>
</div>

<script>
    function toggleEdit() {
        document.getElementById('editForm').classList.toggle('hidden');
    }
</script>

<?php include '../../components/footer.php'; ?>