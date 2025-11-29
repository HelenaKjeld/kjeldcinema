<?php
require_once __DIR__ . '/../OOP/classes/Showing.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../OOP/classes/Invoice.php';
require_once __DIR__ . '/../OOP/classes/Database.php';


$selectedSeats = $_POST['selected_seats']; // array of seat IDs
$showingID = $_POST['showingID'];
$bookingEmail = $_POST['BookingEmail'];
$userID = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

$showing  = new Showing();

$showingDetails  = $showingID ? $showing->find($showingID) : null;

$ticket = new Ticket();
$ticketId = $ticket->createTicketForSeats($showingID, $selectedSeats, $bookingEmail, $userID);

$totalPrice = $showingDetails['Price'] * count($selectedSeats);

$invoice = new Invoice();
$invoiceId = $invoice->createForTicket($ticketId, $totalPrice, $bookingEmail, date('Y-m-d'));

setcookie('invoiceID', $invoiceId, time() + 3600, '/');


$mailSubject = 'Here is the subject';
$mailBody    = 'This is the HTML message body <b>in bold!</b>';
$mailAltBody = 'This is the body in plain text for non-HTML mail clients';
SendEmail("helenakjeld@gmail.com", "helena", $mailSubject, $mailBody, $mailAltBody);


redirect_to("invoice_page.php");
