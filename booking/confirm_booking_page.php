<?php
session_start();

require_once __DIR__ . '/../includes/constants.php';
include __DIR__ . '/../components/header.php';

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// --- 1. Read data coming from booking_page.php ---

$showingId = isset($_POST['showingID']) ? (int)$_POST['showingID'] : 0;
$selectedSeatsIds = isset($_POST['selected_seats']) ? array_map('intval', (array)$_POST['selected_seats']) : [];
$bookingEmail = isset($_POST['booking_email']) ? trim($_POST['booking_email']) : '';

if ($showingId <= 0 || empty($selectedSeatsIds)) {
    // You can redirect back instead if you prefer
    die('No showing or seats selected.');
}

// --- 2. Fetch showing info ---

$showingSql = "
    SELECT 
        s.ShowingID,
        s.DATE       AS ShowingDate,
        s.Time       AS ShowingTime,
        s.Price,
        m.Titel      AS MovieTitle,
        m.Poster     AS PosterImage,
        sr.name      AS ShowroomName
    FROM showing s
    JOIN movie    m  ON m.MovieID     = s.MovieID
    JOIN showroom sr ON sr.ShowroomID = s.ShowroomID
    WHERE s.ShowingID = ?
";
$showingStmt = $mysqli->prepare($showingSql);
$showingStmt->bind_param('i', $showingId);
$showingStmt->execute();
$showingResult = $showingStmt->get_result();
$showing = $showingResult->fetch_assoc();

if (!$showing) {
    die('Showing not found.');
}

// --- 3. Fetch info about the selected seats ---

$placeholders = implode(',', array_fill(0, count($selectedSeatsIds), '?'));
$types = str_repeat('i', count($selectedSeatsIds));

$seatSql = "
    SELECT SeatingID, RowLetters, SeatNumber
    FROM seating
    WHERE SeatingID IN ($placeholders)
    ORDER BY RowLetters ASC, CAST(SeatNumber AS UNSIGNED) ASC
";
$seatStmt = $mysqli->prepare($seatSql);
$seatStmt->bind_param($types, ...$selectedSeatsIds);
$seatStmt->execute();
$seatResult = $seatStmt->get_result();

$seats = [];
while ($row = $seatResult->fetch_assoc()) {
    $seats[] = $row;
}

// --- 4. Calculate total price ---

$pricePerSeat = (float)$showing['Price'];
$totalSeats   = count($seats);
$totalPrice   = $pricePerSeat * $totalSeats;

// Optional: is the user logged in?
$userId = $_SESSION['UserID'] ?? null;
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Confirm booking – <?php echo htmlspecialchars($showing['MovieTitle']); ?></title>

    <!-- Tailwind CDN (if header already includes Tailwind, you can remove this) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-full bg-slate-950 text-slate-100">
    <div class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-4xl bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-black/40 p-6 sm:p-8 space-y-8">

            <!-- Back button -->
            <a href="/booking/booking_page.php?showing=<?php echo $showingId; ?>">
                <button
                    class="border border-amber-400 text-amber-400 mb-4 px-6 py-2 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                    ← Back to seat selection
                </button>
            </a>

            <!-- Header: Showing summary -->
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                <div class="w-28 h-40 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 shadow-lg shadow-black/50">
                    <?php if (!empty($showing['PosterImage'])): ?>
                        <img src="/<?php echo htmlspecialchars($showing['PosterImage']); ?>"
                             alt="Poster"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-xs text-slate-500 px-2 text-center">
                            No poster
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex-1 space-y-2">
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight">
                        Confirm your booking
                    </h1>
                    <p class="text-lg font-medium text-slate-100">
                        <?php echo htmlspecialchars($showing['MovieTitle']); ?>
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs sm:text-sm">
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo htmlspecialchars($showing['ShowroomName']); ?>
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo htmlspecialchars($showing['ShowingDate']); ?>
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo htmlspecialchars(substr($showing['ShowingTime'], 0, 5)); ?>
                        </span>
                    </div>
                    <p class="text-sm text-slate-300">
                        Price per seat:
                        <span class="font-semibold text-sky-300">
                            <?php echo number_format($pricePerSeat, 2); ?> DKK
                        </span>
                    </p>
                </div>
            </div>

            <!-- Selected seats -->
            <div class="bg-slate-800/70 border border-slate-700 rounded-xl p-5 space-y-3">
                <h2 class="text-lg font-semibold text-slate-100">Selected seats</h2>

                <?php if (!empty($seats)): ?>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($seats as $seat): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-900 text-slate-100 border border-slate-600 text-sm">
                                Row <?php echo htmlspecialchars($seat['RowLetters']); ?> – Seat <?php echo htmlspecialchars($seat['SeatNumber']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-slate-300">No seats selected.</p>
                <?php endif; ?>
            </div>

            <!-- Guest info (if not logged in) -->
            <?php if (!$userId): ?>
                <div class="bg-slate-800/70 border border-slate-700 rounded-xl p-5 space-y-3">
                    <h2 class="text-lg font-semibold text-slate-100">Your contact details</h2>
                    <p class="text-sm text-slate-300">
                        Since you are not logged in, we will use this email on your invoice.
                    </p>
                    <div>
                        <input
                            type="email"
                            name="booking_email_display"
                            value="<?php echo htmlspecialchars($bookingEmail); ?>"
                            readonly
                            class="w-full rounded-lg bg-slate-900 border border-slate-600 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-400/70"
                        >
                    </div>
                </div>
            <?php endif; ?>

            <!-- Total summary -->
            <div class="bg-slate-800/70 border border-slate-700 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-300">
                        Seats:
                        <span class="font-semibold text-slate-100"><?php echo $totalSeats; ?></span>
                    </p>
                    <p class="text-sm text-slate-300">
                        Price per seat:
                        <span class="font-semibold text-slate-100">
                            <?php echo number_format($pricePerSeat, 2); ?> DKK
                        </span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-400 uppercase tracking-wide">
                        Total amount
                    </p>
                    <p class="text-2xl font-bold text-amber-400">
                        <?php echo number_format($totalPrice, 2); ?> DKK
                    </p>
                </div>
            </div>

            <!-- Confirm button + hidden form to pass data on -->
            <form
                method="post"
                action="/booking/create_ticket.php"
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-2"
            >
                <!-- Hidden inputs: keep all the data for the next step -->
                <input type="hidden" name="showingID" value="<?php echo $showingId; ?>">

                <?php foreach ($selectedSeatsIds as $id): ?>
                    <input type="hidden" name="selected_seats[]" value="<?php echo (int)$id; ?>">
                <?php endforeach; ?>

                <?php if (!$userId): ?>
                    <input type="hidden" name="BookingEmail" value="<?php echo htmlspecialchars($bookingEmail); ?>">
                <?php endif; ?>

                <p class="text-sm text-slate-400">
                    When you confirm, we will create a ticket and an invoice (fake payment).
                </p>

                <button
                    type="submit"
                    class="self-start sm:self-auto inline-flex items-center justify-center px-8 py-3 rounded-full font-semibold
                           bg-amber-400 text-black hover:bg-amber-300 transition shadow-lg shadow-amber-500/30">
                    Confirm & create invoice
                </button>
            </form>

        </div>
    </div>
</body>
</html>

<?php
$seatStmt->close();
$showingStmt->close();
$mysqli->close();

include __DIR__ . '/../components/footer.php';
?>
