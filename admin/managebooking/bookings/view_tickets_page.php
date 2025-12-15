<?php
require_once __DIR__ . '/../../../includes/constants.php';
require_once __DIR__ . '/../../../includes/functions.php';
include '../../../components/header.php';

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$showingId = isset($_GET['showing']) ? (int)$_GET['showing'] : 0;
if ($showingId <= 0) {
    die('Invalid showing id.');
}

$showingSql = "
    SELECT 
        s.ShowingID,
        s.DATE       AS ShowingDate,
        s.Time       AS ShowingTime,
        s.Price,
        m.Titel      AS MovieTitle,
        m.Poster     AS PosterImage,
        sr.name      AS ShowroomName,
        sr.ShowroomID AS ShowroomID
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

// 🔹 Fetch all seats for this showroom, and mark which are booked for THIS showing
$seatsSql = "
    SELECT 
        se.SeatingID,
        se.RowLetters,
        se.SeatNumber,
        CASE 
            WHEN t.TicketID IS NULL THEN 0
            ELSE 1
        END AS IsBooked
    FROM seating se
    LEFT JOIN ticket_has_a_seating ths 
        ON ths.SeatingID = se.SeatingID
    LEFT JOIN ticket t 
        ON t.TicketID = ths.TicketID 
       AND t.ShowingID = ?
    WHERE se.ShowroomID = ?
    ORDER BY se.RowLetters ASC, CAST(se.SeatNumber AS UNSIGNED) ASC
";

$seatsStmt = $mysqli->prepare($seatsSql);
$seatsStmt->bind_param('ii', $showingId, $showing['ShowroomID']);
$seatsStmt->execute();
$seatsResult = $seatsStmt->get_result();

$seats = [];
while ($row = $seatsResult->fetch_assoc()) {
    $seats[] = $row;
}

// 5. Fetch all tickets for this showing
$ticketsSql = "
    SELECT 
        t.TicketID,
        t.PurchaseDate,
        t.TotalPrice,
        t.UserID,
        t.BookingEmail,
        u.Firstname,
        u.Lastname,
        u.Email AS UserEmail
    FROM ticket t
    LEFT JOIN user u ON u.UserID = t.UserID
    WHERE t.ShowingID = ?
    ORDER BY t.PurchaseDate DESC, t.TicketID DESC
";

$ticketsStmt = $mysqli->prepare($ticketsSql);
$ticketsStmt->bind_param('i', $showingId);
$ticketsStmt->execute();
$ticketsResult = $ticketsStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Tickets for <?php echo politi($showing['MovieTitle']); ?></title>

    <!-- Tailwind CDN (if your header already includes Tailwind, you can remove this) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-full bg-slate-950 text-slate-100">
    <div class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-6xl bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-black/40 p-6 sm:p-8">

            <!-- Back button -->
            <a href="/admin/managebooking/manage_bookings_page.php">
                <button
                    class="border border-amber-400 text-amber-400 mb-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                    Back
                </button>
            </a>

            <!-- Header: showing info -->
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center mb-10">
                <div class="w-32 h-48 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 shadow-lg shadow-black/50">
                    <?php if (!empty($showing['PosterImage'])): ?>
                        <img src="/<?php echo politi($showing['PosterImage']); ?>"
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
                        Tickets for <?php echo politi($showing['MovieTitle']); ?>
                    </h1>
                    <div class="flex flex-wrap gap-2 text-xs sm:text-sm">
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo politi($showing['ShowroomName']); ?>
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo politi($showing['ShowingDate']); ?>
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-slate-100 border border-slate-700">
                            <?php echo politi(substr($showing['ShowingTime'], 0, 5)); ?>
                        </span>
                    </div>
                    <p class="text-sm text-slate-300">
                        Standard price:
                        <span class="font-semibold text-sky-300">
                            <?php echo number_format((float)$showing['Price'], 2); ?> DKK
                        </span>
                    </p>
                </div>
            </div>

            <!-- 🪑 Cinema Screen + Seat Map (visual only) -->
            <div class="mb-10">
                <!-- Screen -->
                <div class="w-full h-16 mb-6 rounded-lg flex items-center justify-center bg-slate-200">
                    <h3 class="text-xl font-bold text-gray-700 uppercase tracking-wide">SCREEN</h3>
                </div>

                <!-- Seat Map -->
                <div class="bg-slate-700 rounded-lg p-4 mb-6">
                    <?php if (!empty($seats)): ?>
                        <?php
                        // Group by row letter
                        $grouped = [];
                        foreach ($seats as $seat) {
                            $grouped[$seat['RowLetters']][] = $seat;
                        }
                        ksort($grouped);
                        ?>
                        <div class="flex flex-col gap-3">
                            <?php foreach ($grouped as $rowLetter => $rowSeats): ?>
                                <div class="flex items-center gap-3">
                                    <!-- Row label -->
                                    <div class="w-6 text-sm font-semibold text-slate-100">
                                        <?php echo politi($rowLetter); ?>
                                    </div>

                                    <!-- Row seats (always fit in available width) -->
                                    <div
                                        class="flex-1 grid gap-2 sm:gap-2"
                                        style="grid-template-columns: repeat(<?php echo count($rowSeats); ?>, minmax(0, 1fr));">
                                        <?php foreach ($rowSeats as $seat): ?>
                                            <?php $isBooked = (bool)$seat['IsBooked']; ?>
                                            <div
                                                class="seat aspect-square w-full min-w-0 flex items-center justify-center rounded select-none
                                                       text-[clamp(10px,1vw,14px)] font-semibold 
                                                       <?php echo $isBooked ? 'bg-red-500 text-white cursor-not-allowed' : 'bg-gray-200 text-black'; ?>"
                                                title="Seat <?php echo politi($rowLetter); ?>-<?php echo politi($seat['SeatNumber']); ?>">
                                                <?php echo politi($seat['SeatNumber']); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="text-gray-200">No seats found for this showroom.</span>
                    <?php endif; ?>
                </div>

                <!-- Legend -->
                <div class="bg-slate-700 rounded-lg p-4 flex flex-wrap gap-6">
                    <div class="flex items-center text-sm text-slate-100">
                        <div class="w-6 h-6 bg-gray-200 rounded mr-2 border border-slate-500"></div>
                        <span>Available</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-100">
                        <div class="w-6 h-6 bg-red-500 rounded mr-2 border border-red-700"></div>
                        <span>Booked</span>
                    </div>
                </div>
            </div>

            <!-- 🎟 Tickets table -->
            <div class="mt-4">
                <?php if ($ticketsResult->num_rows > 0): ?>
                    <div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-950/60">
                        <table class="min-w-full divide-y divide-slate-800 text-sm">
                            <thead class="bg-slate-950/80">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Ticket #
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Buyer
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Email
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Type
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Purchase date
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Total price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 bg-slate-950/40">
                                <?php while ($t = $ticketsResult->fetch_assoc()): ?>
                                    <?php
                                    $isUserTicket = !empty($t['UserID']);
                                    $buyerName = $isUserTicket
                                        ? trim(($t['Firstname'] ?? '') . ' ' . ($t['Lastname'] ?? ''))
                                        : 'Guest';

                                    $email = $isUserTicket
                                        ? ($t['UserEmail'] ?? '')
                                        : ($t['BookingEmail'] ?? '');

                                    $purchaseDate = $t['PurchaseDate'] ?? '';
                                    ?>
                                    <tr class="hover:bg-slate-900/80 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap font-semibold text-slate-100">
                                            #<?php echo (int)$t['TicketID']; ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="font-medium text-slate-100">
                                                <?php echo htmlspecialchars($buyerName ?: 'Guest'); ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-slate-200">
                                            <?php echo htmlspecialchars($email ?: '—'); ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <?php if ($isUserTicket): ?>
                                                <span class="inline-flex items-center rounded-full bg-emerald-900/40 px-2 py-0.5 text-xs font-medium text-emerald-300 border border-emerald-800">
                                                    Registered user
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center rounded-full bg-amber-900/40 px-2 py-0.5 text-xs font-medium text-amber-300 border border-amber-800">
                                                    Guest booking
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-slate-300">
                                            <?php echo htmlspecialchars($purchaseDate ?: '—'); ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sky-300 font-semibold">
                                            <?php echo number_format((float)$t['TotalPrice'], 2); ?> DKK
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="mt-6 rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-6 text-center text-sm text-slate-300">
                        No tickets have been booked for this showing yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// Cleanup
$ticketsStmt->close();
$seatsStmt->close();
$showingStmt->close();
$mysqli->close();

include '../../../components/footer.php';
?>