<?php
require_once __DIR__ . '/BaseModel.php';

class CompanyInfo extends BaseModel
{
    protected $table = "companyinfo";
    protected $primaryKey = "CompanyInfoID";

    public function getCompanyInfo()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveCompanyInfo($data, $logoPath = null)
    {
        $existing = $this->getCompanyInfo();

        if ($existing) {
            // Update existing record
            $stmt = $this->db->prepare("UPDATE {$this->table} 
                SET Name=:n, Description=:d, Email=:e, PhoneNumber=:p, OpeningHours=:o, Address=:a, Logo=:l
                WHERE {$this->primaryKey}=:id");
            $stmt->execute([
                ':n' => $data['Name'],
                ':d' => $data['Description'],
                ':e' => $data['Email'],
                ':p' => $data['PhoneNumber'],
                ':o' => $data['OpeningHours'],
                ':a' => $data['Address'],
                ':l' => $logoPath,
                ':id' => $existing['CompanyInfoID']
            ]);
            return "updated";
        } else {
            // Insert new record
            $stmt = $this->db->prepare("INSERT INTO {$this->table} 
                (Name, Description, Email, PhoneNumber, OpeningHours, Address)
                VALUES (:n, :d, :e, :p, :o, :l, :a)");
            $stmt->execute([
                ':n' => $data['Name'],
                ':d' => $data['Description'],
                ':e' => $data['Email'],
                ':p' => $data['PhoneNumber'],
                ':o' => $data['OpeningHours'],
                ':l' => $logoPath,
                ':a' => $data['Address']
            ]);
            return "added";
        }
    }

    public function deleteCompanyInfo($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey}=:id");
        $stmt->execute([':id' => $id]);
    }
}
