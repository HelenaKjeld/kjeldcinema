<?php
include '../../includes/functions.php';
require_once '../../OOP/classes/User.php';
include '../../components/header.php';

$userObj = new User();

//  Handle Delete Request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    if ($userObj->delete($deleteId)) {
        // Optional: redirect so URL stays clean
        header("Location: manageusers_page.php?status=deleted&ID=$deleteId");
        exit();
    } else {
        echo "<p class='text-red-600 text-center mt-4'>Error deleting user.</p>";
    }
}

//  Get All Users
$getUsers = $userObj->getAll();
?>

<a href="../admin_page.php">
    <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
        Back
    </button>
</a>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Manage Users</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
        <p class="text-green-600 text-center mb-4">
            User with ID <?= htmlspecialchars($_GET['ID']) ?> deleted successfully.
        </p>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse shadow rounded-lg">
            <thead class="text-slate-800 text-left">
                <tr>
                    <th class="p-3">UserID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Edit</th>
                    <th class="p-3">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getUsers as $user): ?>
                    <tr class="border-b text-slate-800 hover:bg-gray-50">
                        <td class="p-3 "><?= $user['UserID'] ?></td>
                        <td class="p-3"><?= htmlspecialchars($user['Firstname'] . ' ' . $user['Lastname']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($user['Email']) ?></td>
                        <td class="p-3">
                            <a href="editUser.php?ID=<?= $user['UserID'] ?>" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Edit</a>
                        </td>
                        <td class="p-3">
                            <a href="?delete=<?= $user['UserID'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?')"
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($getUsers) === 0): ?>
                    <tr><td colspan="5" class="text-center p-4 text-gray-500 italic">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../components/footer.php'; ?>
