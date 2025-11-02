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
                                foreach ($rowSeats as $seat):
                                    $seatId = $row . $seat['SeatNumber'];
                                    // $isBooked = in_array($seatId, $bookedSeats);
                            ?>
                                <div
                                    class="seat w-10 h-10 flex items-center justify-center font-medium rounded
                                        <?= $isBooked ? 'bg-red-500 text-white cursor-not-allowed' : ($isVip ? 'bg-amber-500 text-black' : 'bg-gray-200 text-black hover:bg-blue-500 hover:text-white cursor-pointer') ?>"
                                    data-id="<?= $seatId ?>"
                                    <? 
                                    // $isBooked ? 'style="pointer-events:none;"' : '' 
                                    ?>
                                >
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
    feather.replace();
    AOS.init();

    const seatsContainer = document.getElementById('seats');
    const selectedSeatsContainer = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');
    const proceedBtn = document.getElementById('proceed-btn');

    let selectedSeats = [];

    // Get all seat elements rendered by PHP
    const seatElements = seatsContainer.querySelectorAll('.seat');

    seatElements.forEach(seat => {
        const seatId = seat.dataset.id;
        const isVip = seat.classList.contains('bg-amber-500');
        const isBooked = seat.classList.contains('bg-red-500');

        seat.addEventListener('click', () => {
            if (isBooked) return;

            seat.classList.toggle('selected');

            if (seat.classList.contains('selected')) {
                selectedSeats.push(seatId);
            } else {
                selectedSeats = selectedSeats.filter(id => id !== seatId);
            }

            updateSelectedSeatsDisplay();
            updateTotalPrice();
            updateProceedButton();
        });
    });

    function updateSelectedSeatsDisplay() {
        selectedSeatsContainer.innerHTML = '';

        if (selectedSeats.length === 0) {
            selectedSeatsContainer.innerHTML = '<span class="text-gray-500">No seats selected</span>';
            return;
        }

        selectedSeats.forEach(seatId => {
            const seatElement = document.createElement('span');
            seatElement.className = 'bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center';
            const icon = document.createElement('i');
            icon.setAttribute('data-feather', 'check-circle');
            seatElement.prepend(icon);
            seatElement.appendChild(document.createTextNode(` ${seatId}`));
            selectedSeatsContainer.appendChild(seatElement);
            feather.replace();
        });
    }

    function updateTotalPrice() {
        let total = 0;
        selectedSeats.forEach(seatId => {
            // Find the seat element to check if it's VIP
            const seat = seatsContainer.querySelector(`[data-id="${seatId}"]`);
            const isVip = seat && seat.classList.contains('bg-amber-500');
            total += isVip ? 18 : 12;
        });
        totalPriceElement.textContent = `$${total}`;
    }

    function updateProceedButton() {
        proceedBtn.disabled = selectedSeats.length === 0;
    }
});
</script>

<?php
include 'components/footer.php';
?>