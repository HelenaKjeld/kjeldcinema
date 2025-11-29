<?php
session_start();
require_once __DIR__ . '/../OOP/classes/User.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../components/header.php';

// Redirect if not logged in (safety)
if (empty($_SESSION['user_id'])) {
    header('Location: /login_page.php');
    exit;
}

$userObj   = new User();
$ticketObj = new Ticket();
$userId    = $_SESSION['user_id'];

$feedback  = null;

// Handle delete
if (isset($_POST['deleteAccount'])) {
    $userObj->delete($userId);
    session_destroy();
    header("Location: ../index.php?deleted=1");
    exit();
}

// Handle update
if (isset($_POST['updateProfile'])) {
    $data = [
        'Firstname' => $_POST['Firstname'] ?? '',
        'Lastname'  => $_POST['Lastname']  ?? '',
        'Email'     => $_POST['Email']     ?? ''
    ];
    $userObj->update($userId, $data);
    $feedback = "Profile updated successfully!";
}

// Get user info
$user = $userObj->getById($userId);

// Get tickets (your Ticket::getTicketsByUser method)
$tickets = $ticketObj->getTicketsByUser($userId);
?>

<div class="min-h-screen bg-slate-950 text-slate-100 px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-4xl space-y-8">

        <h1 class="text-3xl sm:text-4xl font-bold text-center mb-2">My Profile</h1>
        <p class="text-center text-slate-400 mb-4">Manage your information and view your purchased tickets.</p>

        <?php if ($feedback): ?>
            <div class="rounded-lg border border-emerald-500/60 bg-emerald-900/30 px-4 py-3 text-sm text-emerald-100">
                <?= politi($feedback) ?>
            </div>
        <?php endif; ?>

        <!-- Profile & delete -->
        <div class="grid grid-cols-1 lg:grid-cols-[2fr,1fr] gap-6 items-start">

            <!-- Profile Info -->
            <form method="POST" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/40 space-y-4">
                <h2 class="text-xl font-semibold mb-1">Personal Information</h2>
                <p class="text-sm text-slate-400 mb-4">
                    Update the information associated with your account.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="Firstname">First name</label>
                        <input
                            type="text"
                            id="Firstname"
                            name="Firstname"
                            value="<?= politi($user['Firstname']) ?>"
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-400/70"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="Lastname">Last name</label>
                        <input
                            type="text"
                            id="Lastname"
                            name="Lastname"
                            value="<?= politi($user['Lastname']) ?>"
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-400/70"
                            required
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="Email">Email</label>
                    <input
                        type="email"
                        id="Email"
                        name="Email"
                        value="<?= politi($user['Email']) ?>"
                        class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-400/70"
                        required
                    >
                </div>

                <button
                    type="submit"
                    name="updateProfile"
                    class="mt-3 inline-flex items-center justify-center px-6 py-2 rounded-full font-semibold
                           bg-amber-400 text-black hover:bg-amber-300 transition"
                >
                    Update profile
                </button>
            </form>

            <!-- Delete Account -->
            <form
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');"
                class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/40 space-y-3"
            >
                <h2 class="text-lg font-semibold">Delete Account</h2>
                <p class="text-sm text-slate-400">
                    This will permanently remove your account and ticket history.
                </p>
                <button
                    type="submit"
                    name="deleteAccount"
                    class="inline-flex items-center justify-center px-6 py-2 rounded-full font-semibold
                           bg-red-500 text-white hover:bg-red-600 transition"
                >
                    Delete account
                </button>
            </form>
        </div>

        <!-- Tickets -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/40">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-xl font-semibold">My Tickets</h2>
                    <p class="text-sm text-slate-400">
                        View your purchased tickets and upcoming showings.
                    </p>
                </div>
            </div>

            <?php if (!empty($tickets)): ?>
                <div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-950/60">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-900/80 text-slate-300">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wide text-xs">Movie</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wide text-xs">Date</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wide text-xs">TIME</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wide text-xs">Price</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wide text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            <?php foreach ($tickets as $ticket): ?>
                                <tr class="hover:bg-slate-900/80 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-100">
                                        <?= politi($ticket['MovieTitle'] ?? '') ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-300">
                                        <?= politi($ticket['ShowingDate'] ?? '') ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-300">
                                        <?= politi($ticket['ShowingTime'] ?? '') ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-amber-300 font-semibold">
                                        <?= isset($ticket['TotalPrice']) ? number_format((float)$ticket['TotalPrice'], 2) . ' DKK' : '' ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <?php if (!empty($ticket['InvoiceID'])): ?>
                                                <a
                                                    href="/booking/invoice_page.php?invoiceID=<?= (int)$ticket['InvoiceID'] ?>"
                                                    class="text-xs inline-flex items-center px-3 py-1 rounded-full border border-slate-600 text-slate-100 hover:bg-slate-800 transition"
                                                >
                                                    View invoice
                                                </a>
                                                <a
                                                    href="/booking/ticket_pdf.php?invoiceID=<?= (int)$ticket['InvoiceID'] ?>"
                                                    class="text-xs inline-flex items-center px-3 py-1 rounded-full bg-sky-500 text-black hover:bg-sky-400 transition"
                                                    target="_blank"
                                                >
                                                    Download ticket
                                                </a>
                                            <?php else: ?>
                                                <span class="text-xs text-slate-500 italic">
                                                    No invoice attached
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-sm text-slate-400 italic mt-2">
                    You have no tickets yet. Time for a movie night? 🍿
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
