<?php
require_once __DIR__ . '/BaseModel.php';

class Showing extends BaseModel
{
    protected $table = "Showing";
    protected $primaryKey = "ShowingID";

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (DATE, Time, Price, MovieID, ShowroomID)
                VALUES (:DATE, :Time, :Price, :MovieID, :ShowroomID)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':DATE' => $data['DATE'],
            ':Time' => $data['Time'],
            ':Price' => $data['Price'],
            ':MovieID' => $data['MovieID'],
            ':ShowroomID' => $data['ShowroomID']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET DATE = :DATE, Time = :Time, Price = :Price,
                    MovieID = :MovieID, ShowroomID = :ShowroomID
                WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':DATE' => $data['DATE'],
            ':Time' => $data['Time'],
            ':Price' => $data['Price'],
            ':MovieID' => $data['MovieID'],
            ':ShowroomID' => $data['ShowroomID'],
            ':id' => $id
        ]);
    }

    
    public function getAllWithDetails()
    {
        $sql = "SELECT 
                    s.ShowingID,
                    s.DATE,
                    s.Time,
                    s.Price,
                    m.Titel AS MovieTitle,
                    r.name AS ShowroomName
                FROM Showing s
                JOIN Movie m ON s.MovieID = m.MovieID
                JOIN Showroom r ON s.ShowroomID = r.ShowroomID
                ORDER BY s.DATE ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
