<?php
include 'components/header.php';
?>

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
            <a href="index.html#now-showing" class="ticket-button px-8 py-3 rounded-full font-bold text-white">View Showtimes</a>
            <a href="contact.html" class="border border-amber-400 text-amber-400 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">Contact Us</a>
          </div>
        </div>
        <div class="md:w-1/3 flex justify-center">
          <div class="w-44 h-44 rounded-xl shadow-2xl bg-slate-800 p-4 flex items-center justify-center">
            <img src="img/logo_placeholder.png" alt="RowanCinema Logo" class="max-w-full max-h-full object-contain">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Highlights -->
  <section class="py-12 px-6 bg-slate-900">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-slate-800 rounded-xl p-6 shadow">
        <div class="flex items-center gap-3 mb-3">
          <div class="bg-amber-500 p-2 rounded-full"><i data-feather="headphones" class="text-black"></i></div>
          <h3 class="text-xl font-semibold">Dolby Atmos</h3>
        </div>
        <p class="text-gray-300">Sound so immersive you’ll hear Mr. Bean drop his teddy three rows back.</p>
      </div>
      <div class="bg-slate-800 rounded-xl p-6 shadow">
        <div class="flex items-center gap-3 mb-3">
          <div class="bg-amber-500 p-2 rounded-full"><i data-feather="maximize" class="text-black"></i></div>
          <h3 class="text-xl font-semibold">4K Projection</h3>
        </div>
        <p class="text-gray-300">Crisp visuals that make every eyebrow raise a cinematic event.</p>
      </div>
      <div class="bg-slate-800 rounded-xl p-6 shadow">
        <div class="flex items-center gap-3 mb-3">
          <div class="bg-amber-500 p-2 rounded-full"><i data-feather="coffee" class="text-black"></i></div>
          <h3 class="text-xl font-semibold">Recliners & Snacks</h3>
        </div>
        <p class="text-gray-300">Kick back, relax, and try not to spill your popcorn during the plot twist.</p>
      </div>
    </div>
  </section>

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
          <div class="h-56 w-full flex items-center justify-center text-gray-400">Map coming soon…</div>
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
include 'components/footer.php';
?>