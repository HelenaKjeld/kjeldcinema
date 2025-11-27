<?php
require_once __DIR__ . '/../OOP/classes/Invoice.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';



$invoiceId = isset($_COOKIE['invoiceID']) ? (int)$_COOKIE['invoiceID'] : 0;
if ($invoiceId <= 0) {
    http_response_code(400);
    exit;
}

$invoiceModel = new Invoice();
$ticketModel  = new Ticket();


$invoice = $invoiceModel->findWithDetails($invoiceId);

// Convenience variables
$status       = $invoice['Status'];
$isPaid       = ($status === 'paid');
$isCancelled  = ($status === 'cancelled');
$amount       = (float)$invoice['FullAmount'];
$createdAt    = $invoice['CreatedAt'];
$dueDate      = $invoice['DueDate'] ?: null;
$billedEmail  = $invoice['BilledEmail'] ?: 'Unknown';
$filePath     = $invoice['FilePath'] ?: null;
include __DIR__ . '/../components/header.php';

$seats = [];
if (!empty($invoice['TicketID'])) {
    $seats = $ticketModel->getSeatsForTicket($invoice['TicketID']);
}
?>
<div class="relative min-h-screen bg-slate-950 text-slate-100 px-4 py-10 sm:px-6 lg:px-8">

    <!-- Confetti canvas (overlay) -->
    <canvas id="confetti-canvas" class="pointer-events-none fixed inset-0 w-full h-full z-40"></canvas>

    <div class="mx-auto max-w-4xl">

        <!-- Back button -->
        <a href="/profile_page.php" class="inline-block mb-6">
            <button class="border border-amber-400 text-amber-400 px-6 py-2 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                ← Back to profile
            </button>
        </a>

        <!-- Main card -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-black/40 p-6 sm:p-8 space-y-6">

            <!-- Header row -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400 mb-1">Invoice</p>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
                        <?= htmlspecialchars($invoice['InvoiceNumber'], ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    <p class="mt-2 text-sm text-slate-400">
                        Created: <span class="text-slate-100"><?= htmlspecialchars($createdAt, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php if ($dueDate): ?>
                            · Due: <span class="text-slate-100"><?= htmlspecialchars($dueDate, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="text-right space-y-2">
                    <?php if ($isPaid): ?>
                        <span class="inline-flex items-center rounded-full bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-300 border border-emerald-700">
                            ● Paid
                        </span>
                    <?php elseif ($isCancelled): ?>
                        <span class="inline-flex items-center rounded-full bg-red-900/40 px-3 py-1 text-xs font-semibold text-red-300 border border-red-700">
                            ● Cancelled
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center rounded-full bg-amber-900/40 px-3 py-1 text-xs font-semibold text-amber-300 border border-amber-700">
                            ● Pending
                        </span>
                    <?php endif; ?>

                    <div>
                        <p class="text-sm text-slate-400 uppercase tracking-wide">
                            Total
                        </p>
                        <p class="text-3xl font-extrabold text-amber-400">
                            <?= number_format($amount, 2) ?> DKK
                        </p>
                    </div>
                </div>
            </div>

            <!-- Billed to + Invoice for -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400 mb-2">Billed to</h2>
                    <p class="text-sm text-slate-200 break-words">
                        <?= htmlspecialchars($billedEmail, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400 mb-2">Invoice for</h2>
                    <p class="text-sm text-slate-200">
                        <?= htmlspecialchars($invoice['MovieTitle'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <p class="text-sm text-slate-300 mt-1">
                        <?= htmlspecialchars($invoice['ShowroomName'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars($invoice['ShowingDate'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars(substr($invoice['ShowingTime'], 0, 5), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                        Ticket #<?= (int)$invoice['TicketID'] ?>
                    </p>
                </div>
            </div>

            <!-- Seats & summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-slate-950/60 border border-slate-800 rounded-xl p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400 mb-3">Seats</h2>

                    <?php if (!empty($seats)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($seats as $seat): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-900 text-slate-100 border border-slate-700 text-xs">
                                    Row <?= htmlspecialchars($seat['RowLetters'], ENT_QUOTES, 'UTF-8') ?> – Seat <?= htmlspecialchars($seat['SeatNumber'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-slate-300">No seat information found for this ticket.</p>
                    <?php endif; ?>
                </div>

                <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-4 space-y-2">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400 mb-2">Summary</h2>
                    <p class="flex justify-between text-sm text-slate-300">
                        <span>Ticket total</span>
                        <span><?= number_format((float)$invoice['TotalPrice'], 2) ?> DKK</span>
                    </p>
                    <p class="flex justify-between text-sm text-slate-300">
                        <span>Invoice amount</span>
                        <span><?= number_format($amount, 2) ?> DKK</span>
                    </p>
                    <p class="flex justify-between text-sm text-slate-300">
                        <span>Status</span>
                        <span class="font-medium"><?= htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') ?></span>
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                <p class="text-xs text-slate-500">
                    Thank you for your booking. Enjoy your movie night! 🍿
                </p>

                <div class="flex flex-wrap gap-3">
                    <?php if ($filePath): ?>
                        <a href="/<?= htmlspecialchars($filePath, ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-semibold
                  border border-slate-500 text-slate-100 hover:bg-slate-800 transition">
                            View PDF invoice
                        </a>
                    <?php endif; ?>

                    <a href="/booking/ticket_pdf.php?invoiceID=<?= (int)$invoiceId ?>" target="_blank"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-semibold
              bg-sky-500 text-black hover:bg-sky-400 transition shadow-lg shadow-sky-500/30">
                        Download ticket (PDF)
                    </a>

                    <button
                        id="replay-confetti"
                        type="button"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-semibold
               bg-amber-400 text-black hover:bg-amber-300 transition shadow-lg shadow-amber-500/30">
                        🎉 Replay confetti
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Confetti script -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    // Confetti celebration
    function launchConfetti(durationMs = 1800) {
        const end = Date.now() + durationMs;

        (function frame() {
            // a few random bursts from the sides/top
            confetti({
                particleCount: 3,
                startVelocity: 30,
                spread: 70,
                ticks: 60,
                origin: {
                    x: Math.random(),
                    y: Math.random() - 0.2
                }
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        })();
    }

    // Auto-fire confetti on page load for non-cancelled invoices
    document.addEventListener('DOMContentLoaded', () => {
        const status = "<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>";
        if (status !== 'cancelled') {
            launchConfetti();
        }

        const replayBtn = document.getElementById('replay-confetti');
        if (replayBtn) {
            replayBtn.addEventListener('click', () => {
                launchConfetti();
            });
        }
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>