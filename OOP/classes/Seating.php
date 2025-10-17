<?php
require_once __DIR__ . '/BaseModel.php';

class Seating extends BaseModel {
    protected $table = "Seating";

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (RowLetters, SeatNumber, ShowroomID) 
                                    VALUES (:RowLetters, :SeatNumber, :ShowroomID)");
        $stmt->execute($data);
    }

    public function getByShowroom($showroomID) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE ShowroomID = :id ORDER BY RowLetters, SeatNumber");
        $stmt->execute([':id' => $showroomID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByShowroom($showroomID) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE ShowroomID = :id");
        $stmt->execute([':id' => $showroomID]);
    }
}
