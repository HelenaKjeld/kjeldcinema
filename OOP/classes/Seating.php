<?php
require_once __DIR__ . '/BaseModel.php';

class Seating extends BaseModel
{
    protected $table = "Seating";
    protected $primaryKey = "SeatingID";

    public function generateSeating($showroomID, $rows, $seatsPerRow)
    {
        $letters = range('A', 'Z');

        for ($r = 0; $r < $rows; $r++) {
            for ($s = 1; $s <= $seatsPerRow; $s++) {
                $this->query(
                    "INSERT INTO Seating (RowLetters, SeatNumber, ShowroomID) 
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
        return $this->fetchAll("SELECT * FROM Seating WHERE ShowroomID = :id ORDER BY RowLetters, SeatNumber", [
            ':id' => $showroomID
        ]);
    }
}
