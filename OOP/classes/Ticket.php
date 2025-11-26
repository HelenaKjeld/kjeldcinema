<?php
require_once 'BaseModel.php';
require_once __DIR__ . '/../../includes/functions.php';

class Ticket extends BaseModel
{
    protected $table = 'ticket';

    public function getTicketsByUser($userId)
    {
        $sql = "SELECT t.*, s.Date, s.ShowingID, m.Titel AS MovieTitle, s.Price
                FROM ticket t
                JOIN showing s ON t.ShowingID = s.ShowingID
                JOIN movie m ON s.MovieID = m.MovieID
                WHERE t.UserID = :userId
                ORDER BY s.Date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTicketForSeats($showingID, $seats, $bookingEmail)
    {
        $Showing = new Showing();
        $showingDetails = $Showing->find($showingID);

        $sql = "INSERT INTO {$this->table} (PurchaseDate, CheckoutSessionID, Status, ShowingID, BookingEmail)
                VALUES (:PurchaseDate, :CheckoutSessionID, :Status, :ShowingID, :BookingEmail)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':PurchaseDate' => date('Y-m-d'),
            ':CheckoutSessionID' => guidv4(),
            ':Status' => 'pending',
            ':ShowingID' => $showingDetails['ShowingID'],
            ':BookingEmail' => htmlspecialchars($bookingEmail)

        ]);

        $ticketId = $this->db->lastInsertId();
        return $ticketId;
    }
}
