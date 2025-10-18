<?php
require_once __DIR__ . '/BaseModel.php';


class Showroom extends BaseModel
{
    protected $table = "Showroom";
    protected $primaryKey = "ShowroomID";

    public function createWithSeating($name, $rows, $seatsPerRow)
    {
        
        $this->query("INSERT INTO Showroom (name) VALUES (:name)", [':name' => $name]);
        $showroomID = $this->db->lastInsertId();

        
        $seating = new Seating();
        $seating->generateSeating($showroomID, $rows, $seatsPerRow);

        return $showroomID;
    }
}

