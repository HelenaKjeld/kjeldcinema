<?php
require_once __DIR__ . '/BaseModel.php';

class Seating extends BaseModel
{
    protected $table = "seating";
    protected $primaryKey = "SeatingID";

    public function generateSeating($showroomID, $rows, $seatsPerRow)
    {
        $letters = range('A', 'Z');

        for ($r = 0; $r < $rows; $r++) {
            for ($s = 1; $s <= $seatsPerRow; $s++) {
                $this->query(
                    "INSERT INTO seating (RowLetters, SeatNumber, ShowroomID) 
                     VALUES (:row, :seat, :sid)",
                    [
                        ':row' => $letters[$r],
                        ':seat' => $s,
                        ':sid' => $showroomID
                    ]
                );
            }
        }
    }

    public function getByShowroom($showroomID)
    {
        return $this->fetchAll("SELECT * FROM seating WHERE ShowroomID = :id ORDER BY RowLetters, SeatNumber", [
            ':id' => $showroomID
        ]);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Build placeholders like "?, ?, ?"
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "
        SELECT SeatingID, RowLetters, SeatNumber
        FROM {$this->table}
        WHERE {$this->primaryKey} IN ($placeholders)
        ORDER BY RowLetters ASC, CAST(SeatNumber AS UNSIGNED) ASC
    ";

        $stmt = $this->db->prepare($sql);

        foreach ($ids as $index => $id) {
            $stmt->bindValue($index + 1, (int)$id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
