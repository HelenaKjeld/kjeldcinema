<?php require_once __DIR__ . '/../OOP/classes/CompanyInfo.php';
$companyinfo = new CompanyInfo();
$info = $companyinfo->getCompanyInfo();
?>


<footer class="bg-black text-white py-12 px-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold text-amber-400 mb-4">RowanCinema</h3>
                <p class="text-gray-400 mb-4">
                    Your ultimate destination for premium Rowan experiences.
                </p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/MrBean" class="text-gray-400 hover:text-amber-400 transition">
                        <i data-feather="facebook"></i>
                    </a>
                    <a href="https://x.com/mrbean?lang=da" class="text-gray-400 hover:text-amber-400 transition">
                        <i data-feather="twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/mrbean/?hl=da" class="text-gray-400 hover:text-amber-400 transition">
                        <i data-feather="instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/user/MrBean" class="text-gray-400 hover:text-amber-400 transition">
                        <i data-feather="youtube"></i>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-4">Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-amber-400 transition">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Movies</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Cinemas</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Promotions</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Information</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Terms of Service</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-amber-400 transition">FAQs</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Contact Us</h4>
                <ul class="space-y-2">
                    <li class="flex items-center text-gray-400">
                        <i data-feather="map-pin" class="mr-2"></i> <?php echo htmlspecialchars($info['Address'] ?? 'N/A'); ?>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i data-feather="phone" class="mr-2"></i> <?php echo htmlspecialchars($info['PhoneNumber'] ?? 'N/A'); ?>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i data-feather="mail" class="mr-2"></i> <?php echo htmlspecialchars($info['Email'] ?? 'N/A'); ?>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i data-feather="time" class="mr-2"></i> Opening hours: <?php echo htmlspecialchars($info['OpeningHours'] ?? 'N/A'); ?>
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