<?php
session_start();
require_once __DIR__ . '/../OOP/classes/User.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';
include '../components/header.php';



$userObj = new User();
$ticketObj = new Ticket();
$userId = $_SESSION['UserID'];

// 🧾 Handle delete
if (isset($_POST['deleteAccount'])) {
    $userObj->delete($userId);
    session_destroy();
    header("Location: ../index.php?deleted=1");
    exit();
}

// 📝 Handle update
if (isset($_POST['updateProfile'])) {
    $data = [
        'Firstname' => $_POST['Firstname'],
        'Lastname'  => $_POST['Lastname'],
        'Email'     => $_POST['Email']
    ];
    $userObj->update($userId, $data);
    echo "<p class='text-green-600 text-center'>Profile updated successfully!</p>";
}

// Get user info
$user = $userObj->getById($userId);

// Get tickets
$tickets = $ticketObj->getTicketsByUser($userId);
?>

<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h2 class="text-3xl font-bold mb-6 text-center">My Profile</h2>

    <!-- Profile Info -->
    <form method="POST" class="bg-white p-6 rounded-lg shadow mb-8">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">Personal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="Firstname" value="<?= htmlspecialchars($user['Firstname']) ?>" class="border p-2 rounded" required>
            <input type="text" name="Lastname" value="<?= htmlspecialchars($user['Lastname']) ?>" class="border p-2 rounded" required>
        </div>
        <input type="email" name="Email" value="<?= htmlspecialchars($user['Email']) ?>" class="border p-2 rounded w-full mt-4" required>
        <button type="submit" name="updateProfile" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">Update</button>
    </form>

    <!-- Delete Account -->
    <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
        <button type="submit" name="deleteAccount" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">Delete Account</button>
    </form>

    <!-- Tickets -->
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-xl font-semibold mb-4 text-slate-800">My Tickets</h3>
        <?php if (count($tickets) > 0): ?>
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">Movie</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?= htmlspecialchars($ticket['MovieTitle']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($ticket['Date']) ?></td>
                            <td class="p-3">$<?= htmlspecialchars($ticket['Price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-500 italic">You have no tickets yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../../components/footer.php'; ?>
