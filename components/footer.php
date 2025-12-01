<?php require_once __DIR__ . '/../OOP/classes/CompanyInfo.php';
require_once __DIR__ . '/../includes/functions.php';
$companyinfo = new CompanyInfo();
$info = $companyinfo->getCompanyInfo();
?>


<footer class="bg-black text-white py-12 px-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold text-amber-400 mb-4">RowanCinema</h3>
                <p class="text-gray-400 mb-4">
                    Your ultimate destination for premium Rowan experiences.
                </p>
                 <!-- SOCIAL MEDIA -->
                <div class="flex space-x-4">

                    <?php if (!empty($info['Facebook'])): ?>
                        <a href="<?= politi($info['Facebook']) ?>" target="_blank" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="facebook"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($info['Twitter'])): ?>
                        <a href="<?= politi($info['Twitter']) ?>" target="_blank" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="twitter"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($info['Instagram'])): ?>
                        <a href="<?= politi($info['Instagram']) ?>" target="_blank" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($info['Youtube'])): ?>
                        <a href="<?= politi($info['Youtube']) ?>" target="_blank" class="text-gray-400 hover:text-amber-400 transition">
                            <i data-feather="youtube"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (empty($info['Facebook']) && empty($info['Twitter']) && empty($info['Instagram']) && empty($info['Youtube'])): ?>
                        <p class="text-gray-500 italic">No social links added.</p>
                    <?php endif; ?>

                </div>
            </div>
            <div>
                <h4 class="font-bold mb-4">Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-400 hover:text-amber-400 transition">Movies</a></li>
                    <li><a href="/about_page.php" class="text-gray-400 hover:text-amber-400 transition">About</a></li>
                    <li><a href="/contact_page.php" class="text-gray-400 hover:text-amber-400 transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Contact Us</h4>
                <ul class="space-y-2">
                    
                    <li class="flex items-center text-gray-400">
                        <i data-feather="map-pin" class="mr-2 text-amber-400 transition"></i>
                        <a
                            href="https://www.google.com/maps/search/<?php echo urlencode($info['Address'] ?? ''); ?>"
                            target="_blank"
                            class="text-gray-400 hover:text-amber-400 transition">
                            <?php echo politi($info['Address'] ?? 'N/A'); ?>
                        </a>
                    </li>

                    <li class="flex items-center text-gray-400">
                        <i data-feather="phone" class="mr-2 text-amber-400 transition"></i>
                        <a href="tel:<?php echo $info['PhoneNumber']; ?>" class="text-gray-400 hover:text-amber-400 transition">
                            <?php echo politi($info['PhoneNumber'] ?? 'N/A'); ?>
                        </a>
                    </li>

            
                    <li class="flex items-center text-gray-400">
                        <i data-feather="mail" class="mr-2 text-amber-400 transition"></i>
                        <a
                            href="mailto:<?php echo $info['Email'] ?? ''; ?>"
                            class="text-gray-400 hover:text-amber-400 transition">
                            <?php echo politi($info['Email'] ?? 'N/A'); ?>
                        </a>
                    </li>

                    <li class="flex items-center text-gray-400">
                        <i data-feather="clock" class="mr-2 text-amber-400 transition"></i> Opening hours: <?php echo politi($info['OpeningHours'] ?? 'N/A'); ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
            <p>© 2025 RowanCinema. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        const icon = mobileMenuButton.querySelector('i');
        if (mobileMenu.classList.contains('hidden')) {
            feather.replace();
        } else {
            icon.setAttribute('data-feather', 'x');
            feather.replace();
        }
    });

    // Close mobile menu when clicking a link
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            const icon = mobileMenuButton.querySelector('i');
            icon.setAttribute('data-feather', 'menu');
            feather.replace();
        });
    });

    // Replace feather icons
    feather.replace();
</script>
</body>

</html>