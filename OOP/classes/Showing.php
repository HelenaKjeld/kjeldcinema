<?php
require_once __DIR__ . '/BaseModel.php';

class Showing extends BaseModel
{
    protected $table = "showing";
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
                FROM showing s
                JOIN movie m ON s.MovieID = m.MovieID
                JOIN showroom r ON s.ShowroomID = r.ShowroomID
                ORDER BY s.DATE ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithMovieAndShowroom(int $showingID): ?array
    {
        $sql = "
            SELECT 
                s.ShowingID,
                s.DATE       AS ShowingDate,
                s.Time       AS ShowingTime,
                s.Price,
                m.Titel      AS MovieTitle,
                m.Poster     AS PosterImage,
                sr.name      AS ShowroomName
            FROM showing s
            JOIN movie    m  ON m.MovieID     = s.MovieID
            JOIN showroom sr ON sr.ShowroomID = s.ShowroomID
            WHERE s.ShowingID = :showingID
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':showingID', $showingID, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getByDate(string $date): array
    {
        // Validates expected YYYY-MM-DD format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return [];
        }

        // NOTE: your column is named `DATE` (reserved word), so keep backticks
        $sql = "SELECT * FROM `showing` WHERE `DATE` = :d ORDER BY `Time` ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':d' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
