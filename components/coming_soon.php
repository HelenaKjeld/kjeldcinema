<?php
require_once __DIR__ . '/../OOP/classes/ComingSoon.php';
$cs = new ComingSoon();
$items = $cs->getUpcomingWithMovies(12); // adjust how many you want
?>

<!-- Coming Soon Section -->
<section class="py-16 px-6 bg-slate-800">
  <div class="container mx-auto">
    <div class="flex justify-between items-center mb-12">
      <h2 class="text-3xl font-bold">Coming Soon</h2>
      <!-- <a href="/kjeldcinema/coming_soon_list.php" class="flex items-center text-amber-400 hover:text-amber-300 transition">
        View All <i data-feather="chevron-right" class="ml-1"></i>
      </a> -->
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
              <!-- <a href="<?= $detailUrl ?>" class="mt-4 inline-block text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                Read more
              </a> -->
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



<!-- Coming Soon Section 
<section class="py-16 px-6 bg-slate-800">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Coming Soon</h2>
            <a href="#" class="flex items-center text-amber-400 hover:text-amber-300 transition">
                View All <i data-feather="chevron-right" class="ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
             Coming Soon Card 1 
            <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="http://static.photos/movie/640x360/5" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-4">
                            <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">June 15</span>
                            <h3 class="text-xl font-bold text-white">Shadow Protocol</h3>
                            <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>

             Coming Soon Card 2 
            <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="http://static.photos/movie/640x360/6" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-4">
                            <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">June 22</span>
                            <h3 class="text-xl font-bold text-white">Ocean's Legacy</h3>
                            <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>

             Coming Soon Card 3 
            <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="http://static.photos/movie/640x360/7" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-4">
                            <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">July 5</span>
                            <h3 class="text-xl font-bold text-white">Lost in Time</h3>
                            <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>

             Coming Soon Card 4 
            <div class="movie-card bg-slate-700 rounded-xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="http://static.photos/movie/640x360/8" alt="Coming Soon" class="w-full h-64 object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-4">
                            <span class="text-white text-sm font-medium bg-black bg-opacity-70 px-3 py-1 rounded-full mb-2 inline-block">July 12</span>
                            <h3 class="text-xl font-bold text-white">The Last Stand</h3>
                            <button class="mt-4 text-white border border-white px-4 py-1 rounded-full text-sm hover:bg-white hover:text-black transition">
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>