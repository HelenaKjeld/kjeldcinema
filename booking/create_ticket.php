<?php
require_once __DIR__ . '/../OOP/classes/Showing.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';
require_once __DIR__ . '/../includes/functions.php';

$selectedSeats = $_POST['selected_seats']; // array of seat IDs
$showingID = $_POST['showingID'];
$bookingEmail = $_POST['BookingEmail'];

$showing  = new Showing();

$showingDetails  = $showingID ? $showing->find($showingID) : null;

$ticket = new Ticket();
$ticketId = $ticket->createTicketForSeats($showingID, $selectedSeats, $bookingEmail);

$_COOKIE['ticketId'] = $ticketId;

redirect_to("checkout.html");
