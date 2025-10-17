<?php
require_once __DIR__ . '/BaseModel.php';

class Showroom extends BaseModel {
    protected $table = "Showroom";

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
        $stmt->execute([':name' => $data['name']]);
        return $this->db->lastInsertId();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE ShowroomID = :id");
        $stmt->execute([':id' => $id]);
    }
}
