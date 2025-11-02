<?php
require_once __DIR__ . '/BaseModel.php';

class Movie extends BaseModel
{
    protected $table = 'movie';
    protected $primaryKey = 'MovieID';

    public function getMoviesWithShowtimes($date): array
    {
        $sql = "SELECT 
                    m.MovieID, m.Titel, m.Description, m.Poster, m.ageRating, m.Duration,
                    s.ShowingID, s.`DATE` AS ShowDate, s.`Time` AS ShowTime, s.Price
                FROM movie m
                INNER JOIN showing s ON m.MovieID = s.MovieID AND s.`DATE` = :date
                ORDER BY m.MovieID DESC, s.`Time` ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['date' => $date]);

        $movies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['MovieID'];

            if (!isset($movies[$id])) {
                $movies[$id] = [
                    'MovieID'    => $row['MovieID'],
                    'Titel'      => $row['Titel'],
                    'Description'=> $row['Description'],
                    'Poster'     => $row['Poster'],
                    'ageRating'  => $row['ageRating'],
                    'Duration'   => $row['Duration'],
                    'Showtimes'  => []
                ];
            }

            $movies[$id]['Showtimes'][] = [
                'ShowingID' => $row['ShowingID'],
                'Date'      => $row['ShowDate'],
                'Time'      => $row['ShowTime'],
                'Price'     => $row['Price']
            ];
        }

        return array_values($movies);
    }
}
