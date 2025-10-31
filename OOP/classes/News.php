<?php
require_once __DIR__ . '/BaseModel.php';

class News extends BaseModel
{
    protected $table = 'news';
    protected $primaryKey = 'NewsID';

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (Titel, Text, BannerImg, ReleaseDate)
                VALUES (:t, :x, :b, :r)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':t' => $data['Titel'],
            ':x' => $data['Text'],
            ':b' => $data['BannerImg'],   // relative path like "banners/..."
            ':r' => $data['ReleaseDate']
        ]);
        return $this->db->lastInsertId();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY ReleaseDate DESC, {$this->primaryKey} DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateById(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET Titel = :t, Text = :x, BannerImg = :b, ReleaseDate = :r
                WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':t'  => $data['Titel'],
            ':x'  => $data['Text'],
            ':b'  => $data['BannerImg'],
            ':r'  => $data['ReleaseDate'],
            ':id' => $id
        ]);
    }

    public function soft(int $id)
    {
        parent::softdelete($id);
    }

    public function getLatest()
    {
        $stmt = $this->db->prepare("SELECT * FROM news ORDER BY ReleaseDate DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
