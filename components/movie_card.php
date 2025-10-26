
 
<?php
require_once __DIR__ . '/../OOP/classes/Movie.php';

$movieObj = new Movie();
$movies = $movieObj->getMoviesWithShowtimes();
?>

<?php if (!empty($movies)): ?>
    <?php foreach ($movies as $movie): ?>
        <div class="bg-slate-800 rounded-xl overflow-hidden mb-12 shadow-lg">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4">
                    <img src="/<?= htmlspecialchars($movie['Poster']) ?>"
                         alt="<?= htmlspecialchars($movie['Titel']) ?>"
                         class="w-full h-full object-cover">
                </div>

                <div class="md:w-3/4 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <h3 class="text-2xl font-bold text-white"><?= htmlspecialchars($movie['Titel']) ?></h3>
                        <div class="flex items-center text-amber-400">
                            <i data-feather="star" class="mr-1"></i>
                            <span><?= rand(3, 5) ?>.<?= rand(0, 9) ?>/5</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="text-xs bg-slate-700 px-2 py-1 rounded">Age <?= htmlspecialchars($movie['ageRating']) ?>+</span>
                        <span class="text-xs bg-slate-700 px-2 py-1 rounded"><?= htmlspecialchars($movie['Duration']) ?> min</span>
                    </div>

                    <p class="text-gray-300 mb-6"><?= htmlspecialchars($movie['Description']) ?></p>

                    <div>
                        <h4 class="font-medium mb-3 text-white">Showtimes</h4>

                        <?php if (!empty($movie['Showtimes'])): ?>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($movie['Showtimes'] as $show): ?>
                                    <a href="/kjeldcinema/booking_page.php?showing=<?= $show['ShowingID'] ?>"
                                       class="bg-slate-700 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-md transition">
                                        <?= date('H:i', strtotime($show['Time'])) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-400 italic">No showtimes available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-gray-400 italic">No movies are currently showing.</p>
<?php endif; ?>

<script>
    feather.replace();
</script>
