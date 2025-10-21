<?php
require_once 'BaseModel.php';

class Ticket extends BaseModel {
    protected $table = 'Ticket';

    public function getTicketsByUser($userId) {
        $sql = "SELECT t.*, s.Date, s.ShowingID, m.Titel AS MovieTitle, s.Price
                FROM Ticket t
                JOIN Showing s ON t.ShowingID = s.ShowingID
                JOIN Movie m ON s.MovieID = m.MovieID
                WHERE t.UserID = :userId
                ORDER BY s.Date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
