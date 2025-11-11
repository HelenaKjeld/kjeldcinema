<?php
require_once 'BaseModel.php';
require_once __DIR__ . '/../../includes/functions.php';


class User extends BaseModel {
    protected $table = 'user';

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE 1"); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE UserID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE UserID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE {$this->table} 
                                    SET Firstname = :fname, Lastname = :lname, Email = :email
                                    WHERE UserID = :id");
        $stmt->execute([
            ':fname' => politi($data['Firstname']),
            ':lname' => politi($data['Lastname']),
            ':email' => politi($data['Email']),
            ':id' => $id
        ]);
        return true;
    }
}
?>
