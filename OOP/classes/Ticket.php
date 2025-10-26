<?php
require_once 'BaseModel.php';

class Ticket extends BaseModel {
    protected $table = 'ticket';

    public function getTicketsByUser($userId) {
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
}
?>
