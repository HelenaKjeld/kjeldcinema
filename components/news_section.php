<?php
require_once __DIR__ . '/../OOP/classes/News.php';
require_once __DIR__ . '/../includes/functions.php';

$newsObj = new News();
$latestNews = $newsObj->getLatest();
?>

<section class="hero-gradient pt-32 pb-20 px-6">
    <div class="container mx-auto">
        <div id="hero-carousel" class="relative w-full">
            <div class="relative overflow-hidden rounded-xl">
                <?php if ($latestNews): ?>
                    <div class="duration-700 ease-in-out" data-carousel-item="active">
                        <div class="flex flex-col md:flex-row items-center h-full">
                            <div class="md:w-1/2 mb-10 md:mb-0">
                                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight text-amber-400">
                                    <?= politi($latestNews['Titel']) ?>
                                </h1>
                                <p class="text-lg text-gray-300 mb-8 max-w-lg">
                                    <?= nl2br(politi($latestNews['Text'])) ?>
                                </p>
                            </div>
                            <div class="md:w-1/2 relative">
                                <div class="relative">
                                    <img src="/<?= politi($latestNews['BannerImg']) ?>" alt="Cinema news" class="rounded-xl shadow-2xl w-full">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400 italic">No news are currently showing.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>