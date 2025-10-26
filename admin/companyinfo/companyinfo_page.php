<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/CompanyInfo.php';
include '../../components/header.php';

$companyModel = new CompanyInfo();

// Handle delete
if (isset($_GET['delete'])) {
    $companyModel->deleteCompanyInfo((int)$_GET['delete']);
    echo "<p class='text-red-600 text-center mt-4'>Company info deleted successfully.</p>";
}

// Handle add/update
if (isset($_POST['saveCompany'])) {
    $result = $companyModel->saveCompanyInfo($_POST, $_FILES['Logo']);
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
                    <img src="/kjeldcinema/<?= htmlspecialchars($info['Logo']) ?>" alt="Company Logo" class="w-32 h-32 object-contain mb-3">
                <?php else: ?>
                    <div class="w-32 h-32 bg-gray-200 flex items-center justify-center text-gray-500 rounded mb-3">No Logo</div>
                <?php endif; ?>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-slate-800"><?= htmlspecialchars($info['Name']) ?></h3>
            <p class="mb-2 text-slate-700"><strong>Description:</strong> <?= nl2br(htmlspecialchars($info['Description'])) ?></p>
            <p class="mb-2 text-slate-700"><strong>Email:</strong> <?= htmlspecialchars($info['Email']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Phone:</strong> <?= htmlspecialchars($info['PhoneNumber']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Opening Hours:</strong> <?= htmlspecialchars($info['OpeningHours']) ?></p>
            <p class="mb-2 text-slate-700"><strong>Address:</strong> <?= htmlspecialchars($info['Address']) ?></p>

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
            <input type="text" name="Name" value="<?= htmlspecialchars($info['Name'] ?? '') ?>" placeholder="Company Name" class="border p-2 rounded w-full text-slate-800" required>
            <textarea name="Description" placeholder="Description" class="border p-2 rounded w-full text-slate-800"><?= htmlspecialchars($info['Description'] ?? '') ?></textarea>
            <input type="email" name="Email" value="<?= htmlspecialchars($info['Email'] ?? '') ?>" placeholder="Email" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="PhoneNumber" value="<?= htmlspecialchars($info['PhoneNumber'] ?? '') ?>" placeholder="Phone Number" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="OpeningHours" value="<?= htmlspecialchars($info['OpeningHours'] ?? '') ?>" placeholder="Opening Hours" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="Address" value="<?= htmlspecialchars($info['Address'] ?? '') ?>" placeholder="Address" class="border p-2 rounded w-full text-slate-800" required>

            <div>
                <label class="block text-gray-700 mb-1">Company Logo:</label>
                <input type="file" name="Logo" accept="image/*" class="border p-2 rounded w-full text-slate-800">
                <?php if (!empty($info['Logo'])): ?>
                    <img src="/kjeldcinema/<?= htmlspecialchars($info['Logo']) ?>" alt="Current Logo" class="w-20 mt-2 rounded">
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
