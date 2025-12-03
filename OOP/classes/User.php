<?php
require_once 'BaseModel.php';
require_once __DIR__ . '/../../includes/functions.php';


class User extends BaseModel
{
    protected $table = 'user';

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE UserID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE UserID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
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

    public function login($email, $password)
    {
        global $conn; // or $pdo, depending on your setup

        $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_role'] = $user['Role'];   
            return true;
        }

        return false;
    }
}
