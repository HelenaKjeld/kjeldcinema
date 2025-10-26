<?php
require_once __DIR__ . '/BaseModel.php';

class ComingSoon extends BaseModel {
    protected $table = 'comingsoon';
    protected $primaryKey = 'ComingSoonID';

    public function add($movieId, $releaseDate) {
        $sql = "INSERT INTO {$this->table} (MovieID, ReleaseDate) VALUES (:movieId, :releaseDate)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':movieId' => $movieId, ':releaseDate' => $releaseDate]);
    }

    public function updateReleaseDate($id, $releaseDate) {
        $sql = "UPDATE {$this->table} SET ReleaseDate = :releaseDate WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':releaseDate' => $releaseDate, ':id' => $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getAllWithMovies() {
        $sql = "SELECT cs.*, m.Titel, m.Poster 
                FROM {$this->table} cs
                JOIN movie m ON cs.MovieID = m.MovieID
                ORDER BY cs.ReleaseDate ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableMovies() {
        $sql = "SELECT * FROM movie WHERE MovieID NOT IN (SELECT MovieID FROM {$this->table})";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
