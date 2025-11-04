<?php
include 'components/header.php';

require_once __DIR__ . '/OOP/classes/Showing.php';
require_once __DIR__ . '/OOP/classes/Movie.php';
require_once __DIR__ . '/OOP/classes/Showroom.php';
require_once __DIR__ . '/OOP/classes/Seating.php';
require_once __DIR__ . '/includes/functions.php';

$seating = new Seating();
$showing = new Showing();
$movie = new Movie();
$showroom = new Showroom();


$showingID = $_GET['showing'] ?? null;

$showingDetails = $showingID ? $showing->find($showingID) : null;
$movieDetails = $showingDetails ? $movie->find($showingDetails['MovieID']) : null;
$showroomDetails = $showingDetails ? $showroom->find($showingDetails['ShowroomID']) : null;

$seats = $showingID ? $seating->getByShowroom($showroomDetails['ShowroomID']) : [];
// $bookedSeats = $showingID ? $seating->getBookedSeats($showingID) : [];
?>


<main class="container mx-auto px-4 py-8">
    <div class="bg-slate-800 rounded-xl shadow-lg p-6 mb-8">
        <a href="/"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                Back to Movies
            </button></a>
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/3">
                <img src="/<?= politi($movieDetails['Poster']) ?>"
                    alt="<?= politi($movieDetails['Titel']) ?>" class="rounded-lg w-full">
                <div class="mt-4">
                    <h2 class="text-2xl font-bold"><?= politi($movieDetails['Titel']) ?></h2>
                    <div class="flex items-center mt-2 text-gray-600">
                        <span class="mr-4"><?= politi($movieDetails['ageRating']) ?></span>
                        <span class="mr-4"><?= politi($movieDetails['Duration']) ?></span>
                        <span>Comedy</span>
                    </div>
                </div>
            </div>
            <div class="md:w-2/3">
                <!-- Seat Quantity Selector -->
                <div class="flex items-center justify-between mb-6 bg-slate-700 p-4 rounded-lg">
                    <div>
                        <p class="text-gray-300">How many seats do you want?</p>
                        <p class="text-sm text-gray-400">Remaining to select: <span id="remaining-count">1</span></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="dec-qty" type="button" class="px-3 py-2 rounded bg-slate-600 hover:bg-slate-500">−</button>
                        <input id="seat-qty" type="number" min="1" max="10" value="1"
                            class="w-16 text-center bg-slate-800 border border-slate-600 rounded p-2 text-white" />
                        <button id="inc-qty" type="button" class="px-3 py-2 rounded bg-slate-600 hover:bg-slate-500">+</button>
                    </div>
                </div>

                <!-- Seat Map -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold"><?= politi($showroomDetails['name']) ?></h3>
                        <p class="text-gray-600"><?= politi(formatShowDateTime($showingDetails['DATE'], $showingDetails['Time'])) ?></p>
                    </div>
                    <div class="bg-slate-700 px-4 py-2 rounded-lg">
                        <span class="font-medium text-amber-600"><?= politi($showingDetails['Price']) ?> kr</span>
                    </div>
                </div>

                <div class="screen w-full h-16 mb-8 rounded-lg flex items-center justify-center">
                    <h3 class="text-xl font-bold text-gray-700">SCREEN</h3>
                </div>

                <div class="bg-slate-700 seat-map mb-8">
                    <div class="grid grid-cols-10 gap-3" id="seats">
                        <?php if ($seats): ?>
                            <?php
                            // Group seats by row
                            $grouped = [];
                            foreach ($seats as $seat) {
                                $grouped[$seat['RowLetters']][] = $seat;
                            }
                            foreach ($grouped as $row => $rowSeats):
                                // Sort seats numerically by SeatNumber
                                usort($rowSeats, function ($a, $b) {
                                    return $a['SeatNumber'] - $b['SeatNumber'];
                                });
                                foreach ($rowSeats as $seat):
                                    $seatId = $seat['SeatNumber']; // Only use the number


                                    // $isBooked and $isVip logic here if needed
                            ?>
                                    <div
                                        class="seat w-10 h-10 flex items-center justify-center font-medium rounded bg-gray-200 text-black hover:bg-blue-500 hover:text-white cursor-pointer"
                                        data-id="<?= $seatId ?>">
                                        <?= $seat['SeatNumber'] ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-gray-500">No seats found</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-slate-700 seat-legend flex flex-wrap gap-6 mb-6">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-gray-200 rounded mr-2"></div>
                        <span>Available</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-blue-500 rounded mr-2"></div>
                        <span>Selected</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-red-500 rounded mr-2"></div>
                        <span>Booked</span>
                    </div>
                </div>

                <div class="bg-slate-700 p-4 rounded-lg mb-6">
                    <h4 class="font-semibold mb-2">Selected Seats</h4>
                    <div id="selected-seats" class="flex flex-wrap gap-2">
                        <span class="text-gray-500">No seats selected</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">Total</p>
                        <h3 class="text-2xl font-bold" id="total-price">$0</h3>
                    </div>
                    <a href="index"><button id="proceed-btn" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Proceed to Payment
                        </button></a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // If you're using feather/AOS elsewhere, keep these:
  if (window.feather) feather.replace();
  if (window.AOS) AOS.init();

  const seatsContainer = document.getElementById('seats');
  const selectedSeatsContainer = document.getElementById('selected-seats');
  const totalPriceElement = document.getElementById('total-price');
  const proceedBtn = document.getElementById('proceed-btn');

  // NEW: quantity controls
  const qtyInput = document.getElementById('seat-qty');
  const decBtn   = document.getElementById('dec-qty');
  const incBtn   = document.getElementById('inc-qty');
  const remainingEl = document.getElementById('remaining-count');

  let selectedSeats = [];
  const MIN_QTY = parseInt(qtyInput?.min || '1', 10);
  const MAX_QTY = parseInt(qtyInput?.max || '10', 10);

  // Attach click handlers to seat tiles rendered by PHP
  const seatElements = seatsContainer.querySelectorAll('.seat');

  seatElements.forEach(seat => {
    seat.addEventListener('click', () => {
      const seatId = seat.dataset.id;
      const isBooked = seat.classList.contains('bg-red-500'); // if you later mark booked seats with this class
      if (isBooked) return;

      const selecting = !seat.classList.contains('selected');

      // Prevent selecting more than chosen qty
      if (selecting && selectedSeats.length >= currentQty()) {
        seat.classList.add('ring-2','ring-red-400'); // tiny visual nudge
        setTimeout(() => seat.classList.remove('ring-2','ring-red-400'), 300);
        return;
      }

      seat.classList.toggle('selected');

      if (seat.classList.contains('selected')) {
        selectedSeats.push(seatId);
      } else {
        selectedSeats = selectedSeats.filter(id => id !== seatId);
      }

      refreshUI();
    });
  });

  // Helpers
  function currentQty() {
    let v = parseInt(qtyInput.value || '1', 10);
    if (isNaN(v)) v = 1;
    return Math.min(Math.max(v, MIN_QTY), MAX_QTY);
  }

  function setQty(v) {
    v = Math.min(Math.max(v, MIN_QTY), MAX_QTY);
    qtyInput.value = v;

    // If we reduced quantity below current selection size, trim extras (last selected go first)
    if (selectedSeats.length > v) {
      const toUnselect = selectedSeats.slice(v); // seats beyond the limit
      toUnselect.forEach(id => {
        const el = seatsContainer.querySelector(`[data-id="${CSS.escape(id)}"]`);
        if (el) el.classList.remove('selected');
      });
      selectedSeats = selectedSeats.slice(0, v);
    }
    refreshUI();
  }

  // Update selected chips
  function updateSelectedSeatsDisplay() {
    selectedSeatsContainer.innerHTML = '';
    if (selectedSeats.length === 0) {
      selectedSeatsContainer.innerHTML = '<span class="text-gray-500">No seats selected</span>';
      return;
    }
    selectedSeats.forEach(seatId => {
      const chip = document.createElement('span');
      chip.className = 'bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center';
      const icon = document.createElement('i');
      icon.setAttribute('data-feather', 'check-circle');
      chip.prepend(icon);
      chip.appendChild(document.createTextNode(' ' + seatId));
      selectedSeatsContainer.appendChild(chip);
    });
    if (window.feather) feather.replace();
  }

  // Price calculation (keeps your VIP logic if you add a VIP class later)
  function updateTotalPrice() {
    let total = 0;
    selectedSeats.forEach(seatId => {
      const seatEl = seatsContainer.querySelector(`[data-id="${CSS.escape(seatId)}"]`);
      const isVip = seatEl && seatEl.classList.contains('bg-amber-500'); // if you color VIP seats
      total += isVip ? 18 : 12; // your existing example pricing
    });
    totalPriceElement.textContent = `$${total}`;
  }

  function updateProceedButton() {
    // Enable only when selected seats count equals chosen quantity
    const ok = selectedSeats.length === currentQty();
    proceedBtn.disabled = !ok;
  }

  function updateRemaining() {
    const rem = Math.max(currentQty() - selectedSeats.length, 0);
    if (remainingEl) remainingEl.textContent = rem;
  }

  function refreshUI() {
    updateSelectedSeatsDisplay();
    updateTotalPrice();
    updateProceedButton();
    updateRemaining();
  }

  // Quantity events
  decBtn?.addEventListener('click', () => setQty(currentQty() - 1));
  incBtn?.addEventListener('click', () => setQty(currentQty() + 1));
  qtyInput?.addEventListener('input', () => setQty(parseInt(qtyInput.value || '1', 10)));

  // Init
  refreshUI();
});
</script>


<?php
include 'components/footer.php';
?>