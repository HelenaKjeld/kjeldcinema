<?php
require_once __DIR__ . '/includes/constants.php';
include __DIR__ . '/components/header.php';

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$about = [
    'HeroTitel'  => 'Welcome to RowanCinema',
    'Herotext'   => 'Your ultimate destination for premium cinematic experiences...',
    'AboutTitle' => 'Our Story',
    'AboutText'  => "Born from a love of laughter, drama, and the occasional silent stare...",
];

$res = $mysqli->query("SELECT HeroTitel, Herotext, AboutTitle, AboutText FROM aboutcinema WHERE Aboutcinema = 1 LIMIT 1");
if ($res && $res->num_rows > 0) {
    $about = $res->fetch_assoc();
}
?>

<!-- hero section
<h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
  <?= htmlspecialchars($about['HeroTitel'], ENT_QUOTES, 'UTF-8') ?>
</h1>
<p class="text-gray-300 mt-6 max-w-2xl">
  <?= nl2br(htmlspecialchars($about['Herotext'], ENT_QUOTES, 'UTF-8')) ?>
</p> -->


  <!-- Hero -->
  <section class="hero-gradient pt-32 pb-16 px-6">
    <div class="container mx-auto">
      <div class="flex flex-col md:flex-row items-center gap-10">
        <div class="md:w-2/3">
          <p class="text-amber-300 uppercase tracking-wider mb-2">About Us</p>
          <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
            Welcome to <span class="text-amber-400">RowanCinema</span>
          </h1>
          <p class="text-gray-300 mt-6 max-w-2xl">
            Your ultimate destination for premium cinematic experiences. From Dolby Atmos to reclining seats,
            we deliver movies with maximum comfort—and a dash of Mr. Bean-style mischief.
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="/" class="ticket-button px-8 py-3 rounded-full font-bold text-white">View Showtimes</a>
            <a href="contact_page.html" class="border border-amber-400 text-amber-400 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">Contact Us</a>
          </div>
        </div>
        <div class="md:w-1/3 flex justify-center">
          <div class="w-44 h-44 rounded-xl shadow-2xl bg-slate-800 p-4 flex items-center justify-center">
            <img src="img/mr_bean_icon.png" alt="RowanCinema Logo" class="max-w-full max-h-full object-contain">
          </div>
        </div>
      </div>
    </div>
  </section>


<!-- Our Story
<h2 class="text-3xl font-bold mb-4">
  <?= htmlspecialchars($about['AboutTitle'], ENT_QUOTES, 'UTF-8') ?>
</h2>
<p class="text-gray-300 leading-relaxed whitespace-pre-line">
  <?= nl2br(htmlspecialchars($about['AboutText'], ENT_QUOTES, 'UTF-8')) ?>
</p> -->

  <!-- Our Story -->
  <section class="py-16 px-6 bg-slate-800">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-3xl font-bold mb-4">Our Story</h2>
        <p class="text-gray-300 leading-relaxed">
          Born from a love of laughter, drama, and the occasional silent stare, RowanCinema started as a small screen
          with big dreams. Today, we’re proud to host the best of cinema—blockbusters and indie gems—served with comfort and humor.
        </p>
        <p class="text-gray-300 mt-4">
          Our mission is simple: make movie nights magical. And if Mr. Bean shows up and presses the wrong button again…
          well, that’s just part of the charm.
        </p>
      </div>
      <div class="bg-slate-700 rounded-xl p-6 shadow grid grid-cols-2 gap-6">
        <div>
          <div class="text-4xl font-extrabold text-amber-400">4K</div>
          <div class="text-gray-300">Projection</div>
        </div>
        <div>
          <div class="text-4xl font-extrabold text-amber-400">7.1</div>
          <div class="text-gray-300">Surround</div>
        </div>
        <div>
          <div class="text-4xl font-extrabold text-amber-400">VIP</div>
          <div class="text-gray-300">Recliners</div>
        </div>
        <div>
          <div class="text-4xl font-extrabold text-amber-400">∞</div>
          <div class="text-gray-300">Popcorn</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Visit Us / Contact -->
  <section class="py-16 px-6 bg-slate-900">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="md:col-span-2 bg-slate-800 rounded-xl p-6 shadow">
        <h3 class="text-2xl font-bold mb-4">Visit Us</h3>
        <p class="text-gray-300 mb-2"><i data-feather="map-pin" class="inline mr-2"></i>123 Cinema St, Movie City</p>
        <p class="text-gray-300 mb-2"><i data-feather="clock" class="inline mr-2"></i>Mon–Sun: 10:00 – 23:00</p>
        <p class="text-gray-300"><i data-feather="phone" class="inline mr-2"></i>(123) 456-7890</p>
        <div class="mt-6 rounded-lg overflow-hidden bg-slate-700">
          <!-- Map placeholder; swap with an embed later -->
          <div class="h-56 w-full flex items-center justify-center text-gray-400"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d633136.5276189636!2d-1.6366670218750168!3d51.6929761!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4876402f2fe350ad%3A0xa43f20856ba6c5!2sWarner%20Bros.%20Studios%20Leavesden!5e0!3m2!1sen!2sdk!4v1762253783415!5m2!1sen!2sdk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
        </div>
      </div>
      <div class="bg-slate-800 rounded-xl p-6 shadow">
        <h3 class="text-2xl font-bold mb-4">Get in Touch</h3>
        <p class="text-gray-300 mb-4">Have a question, suggestion, or a lost teddy bear?</p>
        <a href="mailto:info@rowancinema.example" class="block bg-amber-500 hover:bg-amber-600 text-black font-semibold px-6 py-3 rounded-full text-center transition">
          Email Us
        </a>
        <div class="mt-6 flex gap-4 text-gray-300">
          <a href="#" class="hover:text-amber-400 transition"><i data-feather="facebook"></i></a>
          <a href="#" class="hover:text-amber-400 transition"><i data-feather="twitter"></i></a>
          <a href="#" class="hover:text-amber-400 transition"><i data-feather="instagram"></i></a>
          <a href="#" class="hover:text-amber-400 transition"><i data-feather="youtube"></i></a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-16 px-6 bg-gradient-to-r from-slate-900 to-slate-800">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready for your next movie night?</h2>
      <p class="text-gray-300 mb-8 max-w-2xl mx-auto">Grab a seat, grab a snack, and prepare for cinematic chaos (the fun kind).</p>
      <a href="/" class="ticket-button px-10 py-3 rounded-full font-bold text-white">Browse Showtimes</a>
    </div>
  </section>

  <script>feather.replace();</script>

<?php
// $mysqli->close();
include 'components/footer.php';
?>
