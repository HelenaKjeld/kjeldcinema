<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/OOP/classes/CompanyInfo.php';
$companyinfo = new CompanyInfo();
$info = $companyinfo->getCompanyInfo();



include 'components/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if ($name && $email && $message) {
    $mailSubject = $subject ?: 'Contact Form Submission';
    $mailBody    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b><br>" . nl2br(htmlspecialchars($message));
    $mailAltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Change recipient and name as needed
    $toEmail = 'helenakjeld@gmail.com'; // your cinema's email
    $toName  = 'RowanCinema';

    $sent = SendEmail($toEmail, $toName, $mailSubject, $mailBody, $mailAltBody);

    if ($sent) {
      $successMsg = "Thank you for contacting us! We'll get back to you soon.";
    } else {
      $errorMsg = "Sorry, your message could not be sent. Please try again later.";
    }
  } else {
    $errorMsg = "Please fill in all required fields.";
  }
}
?>

<body class="bg-slate-950 text-slate-100">

  <!-- Hero Section -->
  <section class="pt-10 pb-16 px-6 bg-gradient-to-b from-slate-900 to-slate-800">
    <div class="container mx-auto text-center">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-4">Get in Touch</h1>
      <p class="text-gray-300 max-w-2xl mx-auto">
        Questions, compliments, or just want to tell us Mr. Bean made you spill your popcorn?
        We’d love to hear from you!
      </p>
    </div>
  </section>

  <!-- Contact Form & Info -->
  <section class="py-16 px-6 bg-slate-900">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">
      <!-- Contact Form -->
      <div class="bg-slate-800 rounded-xl p-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-amber-400">Send us a message</h2>
        <?php if (!empty($successMsg)): ?>
          <div class="mb-4 p-3 bg-green-700 text-white rounded"><?= $successMsg ?></div>
        <?php elseif (!empty($errorMsg)): ?>
          <div class="mb-4 p-3 bg-red-700 text-white rounded"><?= $errorMsg ?></div>
        <?php endif; ?>
        <form action="#" method="POST" class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium mb-1 text-gray-300">Full Name</label>
            <input type="text" id="name" name="name" required
              class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium mb-1 text-gray-300">Email</label>
            <input type="email" id="email" name="email" required
              class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>

          <div>
            <label for="subject" class="block text-sm font-medium mb-1 text-gray-300">Subject</label>
            <input type="text" id="subject" name="subject"
              class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 transition">
          </div>

          <div>
            <label for="message" class="block text-sm font-medium mb-1 text-gray-300">Message</label>
            <textarea id="message" name="message" rows="5" required
              class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 transition"></textarea>
          </div>

          <button type="submit"
            class="bg-amber-500 hover:bg-amber-600 text-black font-semibold px-6 py-2.5 rounded-full transition">
            Send Message
          </button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="flex flex-col justify-between">
        <div>
          <h2 class="text-2xl font-bold mb-6 text-amber-400">Visit or Contact Us</h2>
          <ul class="space-y-4">

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


          <div class="flex space-x-4 pt-[20px]">

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


          <!-- <div class="flex gap-4 text-gray-400">
            <a href="#" class="hover:text-amber-400"><i data-feather="facebook"></i></a>
            <a href="#" class="hover:text-amber-400"><i data-feather="instagram"></i></a>
            <a href="#" class="hover:text-amber-400"><i data-feather="twitter"></i></a>
            <a href="#" class="hover:text-amber-400"><i data-feather="youtube"></i></a>
          </div> -->
        </div>

        <!-- Map Placeholder
        <div class="mt-10 bg-slate-800 rounded-xl p-4 h-56 flex items-center justify-center text-gray-400 border border-slate-700">
          Map coming soon…
        </div>-->
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-16 px-6 bg-gradient-to-r from-slate-900 to-slate-800 text-center">
    <div class="container mx-auto">
      <h2 class="text-3xl font-bold mb-4">Join the RowanCinema Experience</h2>
      <p class="text-gray-300 mb-8">We promise the movies are great, and the snacks are even better.</p>
      <a href="/"
        class="ticket-button bg-amber-500 hover:bg-amber-600 text-black font-bold px-8 py-3 rounded-full transition">
        Back to Home
      </a>
    </div>
  </section>

  <?php
  include 'components/footer.php';
  ?>

  <script>
    feather.replace();
  </script>