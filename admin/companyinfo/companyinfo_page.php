<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../includes/connection.php';
$db = dbCon();
include '../../components/header.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM CompanyInfo WHERE CompanyInfoID = :id");
    $stmt->execute([':id' => $deleteId]);
    echo "<p class='text-red-600 text-center mt-4'>Company info deleted successfully.</p>";
}

// Handle Add/Update
if (isset($_POST['saveCompany'])) {
    $stmt = $db->prepare("SELECT * FROM CompanyInfo LIMIT 1");
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update existing record
        $stmt = $db->prepare("UPDATE CompanyInfo 
                              SET Name=:n, Description=:d, Email=:e, PhoneNumber=:p, OpeningHours=:o, Address=:a 
                              WHERE CompanyInfoID=:id");
        $stmt->execute([
            ':n' => $_POST['Name'],
            ':d' => $_POST['Description'],
            ':e' => $_POST['Email'],
            ':p' => $_POST['PhoneNumber'],
            ':o' => $_POST['OpeningHours'],
            ':a' => $_POST['Address'],
            ':id' => $existing['CompanyInfoID']
        ]);
        echo "<p class='text-green-600 text-center mt-4'>Company info updated successfully!</p>";
    } else {
        // Insert new record
        $stmt = $db->prepare("INSERT INTO CompanyInfo (Name, Description, Email, PhoneNumber, OpeningHours, Address)
                              VALUES (:n, :d, :e, :p, :o, :a)");
        $stmt->execute([
            ':n' => $_POST['Name'],
            ':d' => $_POST['Description'],
            ':e' => $_POST['Email'],
            ':p' => $_POST['PhoneNumber'],
            ':o' => $_POST['OpeningHours'],
            ':a' => $_POST['Address']
        ]);
        echo "<p class='text-green-600 text-center mt-4'>Company info added successfully!</p>";
    }
}

// Fetch company info
$stmt = $db->query("SELECT * FROM CompanyInfo LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<a href="../admin_page">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Company Information</h2>

    <?php if ($info): ?>
        <div class="bg-white p-6 rounded-lg shadow mb-6">
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
        <form method="POST" class="grid grid-cols-1 gap-4">
            <input type="text" name="Name" value="<?= htmlspecialchars($info['Name'] ?? '') ?>" placeholder="Company Name" class="border p-2 rounded w-full text-slate-800" required>
            <textarea name="Description" placeholder="Description" class="border p-2 rounded w-full text-slate-800"><?= htmlspecialchars($info['Description'] ?? '') ?></textarea>
            <input type="email" name="Email" value="<?= htmlspecialchars($info['Email'] ?? '') ?>" placeholder="Email" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="PhoneNumber" value="<?= htmlspecialchars($info['PhoneNumber'] ?? '') ?>" placeholder="Phone Number" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="OpeningHours" value="<?= htmlspecialchars($info['OpeningHours'] ?? '') ?>" placeholder="Opening Hours" class="border p-2 rounded w-full text-slate-800" required>
            <input type="text" name="Address" value="<?= htmlspecialchars($info['Address'] ?? '') ?>" placeholder="Address" class="border p-2 rounded w-full text-slate-800" required>

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
