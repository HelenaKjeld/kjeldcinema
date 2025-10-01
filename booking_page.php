<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RowanCinema - Book Your Seats</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="style.css" rel="stylesheet">
    
    

<body class="bg-gray-100">

<?php 
  include 'components/header.php';
?>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <a href="index"><button class="border border-amber-400 text-amber-400 m-6 px-8 py-3 rounded-full font-bold hover:bg-amber-400 hover:text-black transition">
                            Back to Movies
                        </button></a>
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/3">
                    <img src="http://static.photos/movie/640x360/42" alt="Movie Poster" class="rounded-lg w-full">
                    <div class="mt-4">
                        <h2 class="text-2xl font-bold">Avengers: Endgame</h2>
                        <div class="flex items-center mt-2 text-gray-600">
                            <span class="mr-4">PG-13</span>
                            <span class="mr-4">3h 1m</span>
                            <span>Action</span>
                        </div>
                        <div class="mt-4 flex items-center">
                            <div class="flex">
                                <i data-feather="star" class="text-yellow-400 mr-1"></i>
                                <i data-feather="star" class="text-yellow-400 mr-1"></i>
                                <i data-feather="star" class="text-yellow-400 mr-1"></i>
                                <i data-feather="star" class="text-yellow-400 mr-1"></i>
                                <i data-feather="star" class="text-gray-300 mr-1"></i>
                            </div>
                            <span class="ml-2">4.2/5</span>
                        </div>
                    </div>
                </div>
                <div class="md:w-2/3">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold">Screen 5</h3>
                            <p class="text-gray-600">Today, 7:30 PM</p>
                        </div>
                        <div class="bg-gray-100 px-4 py-2 rounded-lg">
                            <span class="font-medium">Standard: $12</span>
                            <span class="mx-2">|</span>
                            <span class="font-medium text-amber-600">VIP: $18</span>
                        </div>
                    </div>

                    <div class="screen w-full h-16 mb-8 rounded-lg flex items-center justify-center">
                        <h3 class="text-xl font-bold text-gray-700">SCREEN</h3>
                    </div>

                    <div class="seat-map mb-8">
                        <div class="grid grid-cols-10 gap-3" id="seats">
                            <!-- Seats will be generated here -->
                        </div>
                    </div>

                    <div class="seat-legend flex flex-wrap gap-6 mb-6">
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
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-amber-500 rounded mr-2"></div>
                            <span>VIP</span>
                        </div>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
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

            // Generate seats
            const seatsContainer = document.getElementById('seats');
            const selectedSeatsContainer = document.getElementById('selected-seats');
            const totalPriceElement = document.getElementById('total-price');
            const proceedBtn = document.getElementById('proceed-btn');

            let selectedSeats = [];
            let ticketCount = 1;
            const bookedSeats = ['A3', 'B5', 'C7', 'D2', 'E4', 'F6']; // Example booked seats
            const vipSeats = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2']; // Example VIP seats

            const rows = ['A', 'B', 'C', 'D', 'E', 'F'];
            const cols = 10;

            rows.forEach(row => {
                for (let col = 1; col <= cols; col++) {
                    const seatId = `${row}${col}`;
                    const seat = document.createElement('div');
                    seat.className = 'seat w-10 h-10 flex items-center justify-center font-medium';
                    seat.classList.add(vipSeats.includes(seatId) ? 'vip' : 'standard');
                    seat.textContent = col;
                    seat.dataset.id = seatId;

                    if (bookedSeats.includes(seatId)) {
                        seat.classList.add('booked');
                    } else if (vipSeats.includes(seatId)) {
                        seat.classList.add('vip');
                    }

                    seat.addEventListener('click', () => {
                        if (seat.classList.contains('booked')) return;

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

                    seatsContainer.appendChild(seat);
                }
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
                    total += vipSeats.includes(seatId) ? 18 : 12;
                });
                totalPriceElement.textContent = `$${total}`;
            }

            function updateProceedButton() {
                proceedBtn.disabled = selectedSeats.length === 0;
            }

            // Ticket counter functionality
            const ticketCountInput = document.getElementById('ticket-count');
            const decrementBtn = document.getElementById('decrement-tickets');
            const incrementBtn = document.getElementById('increment-tickets');

            decrementBtn.addEventListener('click', () => {
                if (ticketCount > 1) {
                    ticketCount--;
                    ticketCountInput.value = ticketCount;
                }
            });

            incrementBtn.addEventListener('click', () => {
                if (ticketCount < 10) {
                    ticketCount++;
                    ticketCountInput.value = ticketCount;
                }
            });

            ticketCountInput.addEventListener('change', () => {
                const value = parseInt(ticketCountInput.value);
                if (isNaN(value) || value < 1) {
                    ticketCount = 1;
                    ticketCountInput.value = 1;
                } else if (value > 10) {
                    ticketCount = 10;
                    ticketCountInput.value = 10;
                } else {
                    ticketCount = value;
                }
            });
        });
    </script>
</body>
</html>
