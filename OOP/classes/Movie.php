<?php
require_once __DIR__ . '/BaseModel.php';

class Movie extends BaseModel
{
    protected $table = 'Movie';
    protected $primaryKey = 'MovieID';

    public function getMoviesWithShowtimes(): array
    {
        // DATE and Time are reserved words – wrap them in backticks
        $sql = "SELECT 
                    m.MovieID, m.Titel, m.Description, m.Poster, m.ageRating, m.Duration,
                    s.ShowingID, s.`DATE` AS ShowDate, s.`Time` AS ShowTime, s.Price
                FROM Movie m
                LEFT JOIN Showing s ON m.MovieID = s.MovieID
                ORDER BY m.MovieID DESC, s.`Time` ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

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

            if (!empty($row['ShowingID'])) {
                $movies[$id]['Showtimes'][] = [
                    'ShowingID' => $row['ShowingID'],
                    'Date'      => $row['ShowDate'],
                    'Time'      => $row['ShowTime'],
                    'Price'     => $row['Price']
                ];
            }
        }

        // optional: reindex to a simple numeric array
        return array_values($movies);
    }
}
