<?php
require_once __DIR__ . '/../OOP/classes/ComingSoon.php';
require_once __DIR__ . '/../includes/functions.php';
$cs = new ComingSoon();
$items = $cs->getUpcomingWithMovies(12); // adjust how many you want
?>

<!-- Coming Soon Section -->
<section class="py-16 px-6 bg-slate-800">
  <div class="container mx-auto">
    <div class="flex justify-between items-center mb-12">
      <h2 class="text-3xl font-bold">Coming Soon</h2>
    </div>

    <?php if (!empty($items)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <?php foreach ($items as $row): 
        $title = politi($row['Titel']);
        $poster = !empty($row['Poster']) ? '/' . ltrim($row['Poster'], '/') : null;
        $dateStr = $row['ReleaseDate'] ? date('F j', strtotime($row['ReleaseDate'])) : 'TBA';
        $detailUrl = '/kjeldcinema/movie_detail.php?id=' . (int)$row['MovieID']; // adjust if you use another route
      ?>
      <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
        <div class="relative">
          <?php if ($poster): ?>
            <img src="<?= $poster ?>" alt="<?= $title ?>" class="w-full h-64 object-cover opacity-70">
          <?php else: ?>
            <div class="w-full h-64 opacity-70 bg-gradient-to-br from-slate-600 to-slate-500 flex items-center justify-center">
              <span class="text-white/80">No Poster</span>
            </div>
          <?php endif; ?>

          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center px-4">
              <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">
                <?= $dateStr ?>
              </span>
              <h3 class="text-xl font-bold text-white"><?= $title ?></h3>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <div class="rounded-xl bg-slate-700 p-10 text-center text-white/80">
        Nothing on the horizon… Mr. Bean is still negotiating with the popcorn 🍿
      </div>
    <?php endif; ?>
  </div>
</section>

<script>feather.replace();</script>