<?php
namespace App;

use App\Helpers\Misc;

class DB {
    private \PDO $conn;

    function __construct() {
        $driver = Misc::env('DB_DRIVER', 'mysql');
        $host = Misc::env('DB_HOST', 'localhost');
        $port = Misc::env('DB_PORT', 3306);
        $user = Misc::env('DB_USERNAME');
        $passwd = Misc::env('DB_PASSWORD');
        $name = Misc::env('DB_DATABASE');
        $dns = $driver .
        ':host=' . $host .
        ';port=' . $port .
        ';dbname=' . $name;
        $this->conn = new \PDO($dns, $user, $passwd);
    }

    /**
     * Get all opinions of a teacher
     */
    public function getReviews(string $idnc): array {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes FROM reviews WHERE `idnc`=:idnc');
        $stmt->execute([
            ':idnc' => $idnc
        ]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getStatsTeacher(string $idnc): object {
        $med = 0;
        $min = 0;
        $max = 0;
        $notes = 0;

        $stmt = $this->conn->prepare('SELECT note FROM reviews WHERE `idnc`=:idnc ORDER BY note DESC');
        $stmt->execute([
            ':idnc' => $idnc
        ]);

        $res = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        if ($res && count($res) > 0) {
            $med = array_sum($res) / count($res);
            $max = $res[0];
            $min = $res[count($res) - 1];
            $notes = count($res);
        }

        return (object) [
            'med' => $med,
            'min' => $min,
            'max' => $max,
            'total' => $notes
        ];
    }

    /**
     * Add opinion on teacher
     */
    public function addReview(string $idnc, string $username, float $note, string $message) {
        $stmt = $this->conn->prepare('INSERT INTO reviews (idnc, username, note, `message`) VALUES (:idnc, :username, :note, :message)');
        $stmt->execute([
            ':idnc' => $idnc,
            ':username' => $username,
            ':note' => $note,
            ':message' => $message
        ]);
    }

    public function changeVote(int $id, bool $more) {
        $change = $more ? 1 : -1;

        $stmt = $this->conn->prepare("UPDATE reviews SET votes = (votes + :change) WHERE id=:id");
        $stmt->execute([
            ':id' => $id,
            ':change' => $change
        ]);
    }
}
