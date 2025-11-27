<?php
// ticket/ticket_pdf.php

require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../OOP/classes/Invoice.php';
require_once __DIR__ . '/../OOP/classes/Ticket.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php'; // adjust path if different

// 1. Read invoice ID
$invoiceId = isset($_GET['invoiceID']) ? (int)$_GET['invoiceID'] : 0;
if ($invoiceId <= 0) {
    http_response_code(400);
    exit('Invalid invoice ID');
}

// 2. Load models
$invoiceModel = new Invoice();
$ticketModel  = new Ticket();

// 3. Fetch invoice + details
$invoice = $invoiceModel->findWithDetails($invoiceId);

if (!$invoice) {
    http_response_code(404);
    exit('Invoice not found');
}

// Optional: here you should verify that the logged-in user
// is allowed to see this ticket (e.g. matches ticket user or email)

// 4. Fetch seats for this ticket
$ticketId = (int)$invoice['TicketID'];
$seats    = $ticketModel->getSeatsForTicket($ticketId);

// 5. Extract convenience variables
$invoiceNumber = $invoice['InvoiceNumber'];
$movieTitle    = $invoice['MovieTitle'];
$showroomName  = $invoice['ShowroomName'];
$showDate      = $invoice['ShowingDate'];
$showTime      = substr($invoice['ShowingTime'], 0, 5);
$fullAmount    = (float)$invoice['FullAmount'];
$billedEmail   = $invoice['BilledEmail'] ?: 'Unknown';

// Format seats as text
$seatStrings = [];
foreach ($seats as $seat) {
    $seatStrings[] = 'Row ' . $seat['RowLetters'] . ' - ' . $seat['SeatNumber'];
}
$seatLine = implode(', ', $seatStrings);

// 6. Create PDF ticket with FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Colors
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(15, 23, 42); // slate-900-ish
$pdf->Rect(0, 0, 210, 297, 'F'); // full dark background

// Ticket card background
$pdf->SetFillColor(15, 23, 42);      // slate-900
$pdf->SetDrawColor(148, 163, 184);   // slate-400 border

// Title
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetXY(20, 28);
$pdf->Cell(0, 10, 'RowanCinema Ticket', 0, 1, 'L');

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(148, 163, 184); // slate-400
$pdf->SetXY(20, 38);
$pdf->Cell(0, 7, 'Invoice: ' . $invoiceNumber, 0, 1, 'L');
$pdf->Cell(0, 7, 'Ticket ID: ' . $ticketId, 0, 1, 'L');

// Movie title
$pdf->SetTextColor(248, 250, 252); // slate-50
$pdf->SetFont('Arial', 'B', 16);
$pdf->Ln(4);
$pdf->Cell(0, 8, $movieTitle, 0, 1, 'L');

// Showroom + date/time
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(226, 232, 240); // slate-200
$pdf->Cell(0, 6, 'Showroom: ' . $showroomName, 0, 1, 'L');
$pdf->Cell(0, 6, 'Date: ' . $showDate . '   Time: ' . $showTime, 0, 1, 'L');

// Seats
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(248, 250, 252);
$pdf->Cell(0, 6, 'Seats:', 0, 1, 'L');

$pdf->SetFont('Arial', '', 12);

// If too many seats, wrap text
$pdf->MultiCell(0, 6, $seatLine !== '' ? $seatLine : 'No seats registered', 0, 'L');

// Billed to
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'Billed to:', 0, 1, 'L');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, $billedEmail, 0, 1, 'L');

// Price
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(250, 204, 21); // amber-ish
$pdf->Cell(0, 8, 'Total: ' . number_format($fullAmount, 2) . ' DKK', 0, 1, 'L');

// Optional: QR / code placeholder
$pdf->Ln(6);
$pdf->SetTextColor(148, 163, 184);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 6, 'Please present this ticket at the cinema entrance.', 0, 1, 'L');

// Tear line style
$pdf->SetDrawColor(51, 65, 85); // slate-700
$pdf->SetLineWidth(0.3);


// 7. Output as PDF in browser
$filename = 'ticket-' . $invoiceNumber . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
$pdf->Output('I', $filename);
exit;
