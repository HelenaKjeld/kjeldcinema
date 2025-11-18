<?php
session_start();

require_once __DIR__ . '/../../includes/constants.php';
include __DIR__ . '../../../components/header.php';

// TODO: protect this page so only admins can access it
// if (empty($_SESSION['is_admin'])) { http_response_code(403); exit('Forbidden'); }

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$errors  = [];
$success = false;

// --- Handle POST (update) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heroTitle  = trim($_POST['HeroTitel'] ?? '');
    $heroText   = trim($_POST['Herotext'] ?? '');
    $aboutTitle = trim($_POST['AboutTitle'] ?? '');
    $aboutText  = trim($_POST['AboutText'] ?? '');

    if ($heroTitle === '')  { $errors[] = 'Hero title is required.'; }
    if ($heroText === '')   { $errors[] = 'Hero text is required.'; }
    if ($aboutTitle === '') { $errors[] = 'About title is required.'; }
    if ($aboutText === '')  { $errors[] = 'About text is required.'; }

    if (!$errors) {
        // Check if row exists
        $check = $mysqli->query("SELECT Aboutcinema FROM aboutcinema WHERE Aboutcinema = 1 LIMIT 1");

        if ($check && $check->num_rows > 0) {
            // Update existing
            $stmt = $mysqli->prepare("
                UPDATE aboutcinema
                SET HeroTitel = ?, Herotext = ?, AboutTitle = ?, AboutText = ?
                WHERE Aboutcinema = 1
            ");
        } else {
            // Insert first row
            $stmt = $mysqli->prepare("
                INSERT INTO aboutcinema (Aboutcinema, HeroTitel, Herotext, AboutTitle, AboutText)
                VALUES (1, ?, ?, ?, ?)
            ");
        }

        if ($stmt) {
            $stmt->bind_param('ssss', $heroTitle, $heroText, $aboutTitle, $aboutText);
            if ($stmt->execute()) {
                $success = true;
            } else {
                $errors[] = 'Database error while saving.';
            }
            $stmt->close();
        } else {
            $errors[] = 'Failed to prepare database statement.';
        }
    }
}

// --- Load current content (after POST so we see updated values) ---
$current = [
    'HeroTitel'  => '',
    'Herotext'   => '',
    'AboutTitle' => '',
    'AboutText'  => '',
];

$res = $mysqli->query("SELECT * FROM aboutcinema WHERE Aboutcinema = 1 LIMIT 1");
if ($res && $res->num_rows > 0) {
    $current = $res->fetch_assoc();
}

?>
<div class="px-6 py-8 max-w-4xl mx-auto">
    <a href="/admin/admin_page.php">
        <button class="border border-amber-400 text-amber-400 mb-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
            ← Back to admin
        </button>
    </a>

    <h1 class="text-3xl font-bold mb-4 text-slate-100">Manage About Page</h1>
    <p class="text-slate-300 mb-6">
        Update the hero and about text shown on the public <code>about_page.php</code>.
    </p>

    <?php if ($success): ?>
        <p class="mb-4 text-green-400">About page content saved successfully.</p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="mb-4 rounded-lg bg-red-900/40 border border-red-600 px-4 py-3 text-sm text-red-100">
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 space-y-6">
        <!-- Hero section -->
        <div>
            <h2 class="text-xl font-semibold text-slate-100 mb-2">Hero Section</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="HeroTitel">Hero title</label>
                    <input
                        type="text"
                        id="HeroTitel"
                        name="HeroTitel"
                        class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100"
                        value="<?= htmlspecialchars($current['HeroTitel'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="Herotext">Hero text</label>
                    <textarea
                        id="Herotext"
                        name="Herotext"
                        rows="3"
                        class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100"
                        required
                    ><?= htmlspecialchars($current['Herotext'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <!-- About section -->
        <div>
            <h2 class="text-xl font-semibold text-slate-100 mb-2">About Section</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="AboutTitle">About title</label>
                    <input
                        type="text"
                        id="AboutTitle"
                        name="AboutTitle"
                        class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100"
                        value="<?= htmlspecialchars($current['AboutTitle'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="AboutText">About text</label>
                    <textarea
                        id="AboutText"
                        name="AboutText"
                        rows="6"
                        class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100"
                        required
                    ><?= htmlspecialchars($current['AboutText'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <button
            type="submit"
            class="inline-flex items-center justify-center px-8 py-3 rounded-full font-semibold
                   bg-amber-400 text-black">
            Save changes
        </button>
    </form>
</div>

<?php
$mysqli->close();
include __DIR__ . '/../../components/footer.php';
?>
