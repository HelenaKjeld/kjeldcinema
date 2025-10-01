<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RowanCinema - Venues</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <link href="style.css" rel="stylesheet">
</head>
<body class="index min-h-screen">

<?php include 'components/header.php'; ?>

<main class="container mx-auto px-4 py-16">
  <h1 class="text-4xl font-bold text-center text-amber-400 mb-12">🎥 RowanCinema Venues</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10">
    <?php 
      $venues = [
        "The Wobbly Screen",
        "Bean’s Balcony",
        "The Teddy Theater",
        "Merry Mayhem Hall",
        "Popcorn Paradise",
        "Laugh Lounge",
        "Slapstick Stage",
        "Silent Giggle Room",
        "The Banana Seat",
        "Mr. Bean’s VIP Den"
      ];
      
      foreach ($venues as $venue) {
    ?>
    <div class="bg-slate-800 p-6 rounded-2xl shadow-lg text-white">
      <h2 class="text-2xl font-bold text-amber-400 mb-4"><?php echo $venue; ?></h2>
      <p class="text-gray-400 mb-4">Screen: 1</p>

      <!-- Screen -->
      <div class="screen w-full h-10 bg-slate-700 rounded-lg flex items-center justify-center mb-6">
        <span class="text-sm font-semibold text-gray-300">SCREEN</span>
      </div>

      <!-- Seating Grid -->
      <div class="overflow-x-auto">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr>
              <th class="p-2"></th>
              <?php foreach(range('A', 'J') as $col): ?>
                <th class="p-2 text-gray-400"><?php echo $col; ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php 
              for ($row = 1; $row <= 6; $row++) {
                echo "<tr>";
                echo "<td class='p-2 text-gray-400 font-medium'>{$row}</td>";
                foreach(range('A', 'J') as $col) {
                  $seatId = $col . $row;
                  $isVip = in_array($seatId, ['A1','A2','B1','B2','C1','C2']);
                  $isHandicapped = in_array($seatId, ['E1','E2','F1','F2']);
                  $color = $isVip ? 'bg-amber-500' : ($isHandicapped ? 'bg-blue-500' : 'bg-gray-300');
                  echo "<td class='p-2'><div class='w-6 h-6 {$color} rounded-md mx-auto'></div></td>";
                }
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Legend -->
      <div class="flex flex-wrap gap-6 mt-6">
        <div class="flex items-center">
          <div class="w-6 h-6 bg-gray-300 rounded mr-2"></div>
          <span class="text-sm">Standard</span>
        </div>
        <div class="flex items-center">
          <div class="w-6 h-6 bg-amber-500 rounded mr-2"></div>
          <span class="text-sm">VIP</span>
        </div>
        <div class="flex items-center">
          <div class="w-6 h-6 bg-blue-500 rounded mr-2"></div>
          <span class="text-sm">Handicapped</span>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</main>



<script>
  feather.replace();
</script>

</body>
</html>
