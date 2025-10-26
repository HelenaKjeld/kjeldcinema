<?php
require_once __DIR__ . '/BaseModel.php';


class Showroom extends BaseModel
{
    protected $table = "showroom";
    protected $primaryKey = "ShowroomID";

    public function createWithSeating($name, $rows, $seatsPerRow)
    {
        
        $this->query("INSERT INTO showroom (name) VALUES (:name)", [':name' => $name]);
        $showroomID = $this->db->lastInsertId();

        
        $seating = new Seating();
        $seating->generateSeating($showroomID, $rows, $seatsPerRow);

        return $showroomID;
    }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE IsDeleted = FALSE");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET IsDeleted = TRUE WHERE {$this->primaryKey} = :id");
        return $stmt->execute([':id' => $id]);
    }
}

