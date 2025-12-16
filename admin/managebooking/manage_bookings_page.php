<?php
include '../../includes/functions.php';
require_once __DIR__ . '/../../OOP/classes/Database.php';
require_once __DIR__ . '/../../includes/session.php';
require_admin();
include '../../components/header.php';

// Optional filters
$date = isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : null;
$movieSearch = isset($_GET['q']) && $_GET['q'] !== '' ? $_GET['q'] : null;

$sql = "SELECT * FROM v_booking_overview WHERE 1=1";
$params = [];

if ($date) {
    $sql .= " AND `ShowingDate` = :d";
    $params[':d'] = $date;
}
if ($movieSearch) {
    $sql .= " AND `MovieName` LIKE :q";
    $params[':q'] = '%' . $movieSearch . '%';
}
$sql .= " ORDER BY `ShowingDate`, `ShowingTime`";

$database = Database::getInstance(); 

$stmt = $database->getConnection()->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<a href="/admin/admin_page.php" class="inline-block">
  <button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
    Back
  </button>
</a>

<div class="p-6">
  <h2 class="text-2xl font-bold mb-6">Manage Bookings</h2>

  <!-- Filters -->
  <form method="GET" class="bg-slate-800 p-4 rounded-xl mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">Date</label>
      <input type="date" name="date" value="<?= politi($date ?? '') ?>"
             class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 text-white focus:ring-amber-500 focus:border-amber-500">
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">Movie</label>
      <input type="text" name="q" placeholder="Search by title..." value="<?= politi($movieSearch ?? '') ?>"
             class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2.5 text-white focus:ring-amber-500 focus:border-amber-500">
    </div>
    <div class="flex items-end">
      <button class="ticket-button px-6 py-2.5 rounded-full font-semibold text-white">Apply Filters</button>
      <a href="manage_bookings_page.php" class="ml-3 px-6 py-2.5 rounded-full border border-slate-500 text-gray-300 hover:bg-slate-700">Reset</a>
    </div>
  </form>

  <!-- Results -->
  <?php if (!$rows): ?>
    <p class="text-gray-400 italic">No showings found.</p>
  <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full bg-white/5 border-collapse shadow rounded-lg">
        <thead class="bg-slate-800 text-left">
          <tr>
            <th class="p-3 text-slate-100">Poster</th>
            <th class="p-3 text-slate-100">Movie</th>
            <th class="p-3 text-slate-100">Date & Time</th>
            <th class="p-3 text-slate-100">Venue</th>
            <th class="p-3 text-slate-100">Booked / Max</th>
            <th class="p-3 text-slate-100">Occupancy</th>
            <th class="p-3 text-slate-100">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-slate-900/60">
          <?php foreach ($rows as $r):
            $poster = $r['PosterImage'] ?? '';
            $movie  = $r['MovieName'] ?? '';
            $date   = $r['ShowingDate'] ?? '';
            $time   = $r['ShowingTime'] ?? '';
            $venue  = $r['VenueName'] ?? '';
            $booked = (int)($r['BookedSeats'] ?? 0);
            $max    = (int)($r['MaxSeats'] ?? 0);
            $occ    = $max > 0 ? round(($booked / $max) * 100) : 0;
            $detail = ('/admin/managebooking/bookings/view_tickets_page.php?showing=' . (int)$r['ShowingID']);

            // Occupancy bar color
            $bar = 'bg-green-500';
            if ($occ >= 75) $bar = 'bg-red-500';
            elseif ($occ >= 40) $bar = 'bg-amber-500';
          ?>
            <tr class="border-b border-slate-800 hover:bg-slate-800/60">
              <td class="p-3">
                <?php if ($poster): ?>
                  <img src="/<?= politi($poster) ?>" alt="poster" class="w-12 h-16 object-cover rounded">
                <?php else: ?>
                  <div class="w-12 h-16 rounded bg-slate-700 flex items-center justify-center text-xs text-gray-400">No<br>Img</div>
                <?php endif; ?>
              </td>
              <td class="p-3 text-slate-100"><?= politi($movie) ?></td>
              <td class="p-3 text-slate-200">
                <?= politi($date) ?> <span class="text-gray-400">at</span> <?= politi(substr($time,0,5)) ?>
              </td>
              <td class="p-3 text-slate-200"><?= politi($venue) ?></td>
              <td class="p-3 text-slate-200"><?= $booked ?>/<?= $max ?></td>
              <td class="p-3">
                <div class="w-40 bg-slate-700 rounded h-3 overflow-hidden">
                  <div class="<?= $bar ?> h-3" style="width: <?= $occ ?>%;"></div>
                </div>
                <div class="text-xs text-gray-400 mt-1"><?= $occ ?>%</div>
              </td>
              <td class="p-3">
                <a href="<?= politi($detail) ?>"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded inline-flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  See tickets
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-slate-800">
          <tr>
            <td colspan="7" class="p-3 text-right text-gray-300">
              Total showings: <?= count($rows) ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include '../../components/footer.php'; ?>
