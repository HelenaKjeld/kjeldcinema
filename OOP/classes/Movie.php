<?php
require_once __DIR__ . '/BaseModel.php';

class Movie extends BaseModel
{
    protected $table = 'movie';
    protected $primaryKey = 'MovieID';

    public function getMoviesWithShowtimesByDate(string $date): array
    {
        $sql = "
            SELECT
                m.MovieID,
                m.Titel,
                m.Poster,
                m.Description,
                m.ageRating,
                m.Duration,
                s.ShowingID,
                s.Time
            FROM movie m
            JOIN showing s ON s.MovieID = m.MovieID
            WHERE s.DATE = :d
            ORDER BY m.Titel ASC, s.Time ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':d' => $date]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group rows into movies + Showtimes[]
        $movies = [];
        foreach ($rows as $r) {
            $mid = (int)$r['MovieID'];

            if (!isset($movies[$mid])) {
                $movies[$mid] = [
                    'MovieID'     => $r['MovieID'],
                    'Titel'       => $r['Titel'],
                    'Poster'      => $r['Poster'],
                    'Description' => $r['Description'],
                    'ageRating'   => $r['ageRating'],
                    'Duration'    => $r['Duration'],
                    'Showtimes'   => []
                ];
            }

            $movies[$mid]['Showtimes'][] = [
                'ShowingID' => $r['ShowingID'],
                'Time'      => $r['Time'],
            ];
        }

        return array_values($movies);
    }
}
