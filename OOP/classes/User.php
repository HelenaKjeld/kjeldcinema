<?php
require_once 'BaseModel.php';

class User extends BaseModel {
    protected $table = 'User';

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
            ':fname' => $data['Firstname'],
            ':lname' => $data['Lastname'],
            ':email' => $data['Email'],
            ':id' => $id
        ]);
        return true;
    }
}
?>
