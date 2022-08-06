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
        $stats = new \stdClass;
        $stats->med = 0;
        $stats->min = 0;
        $stats->max = 0;
        $stats->total = 0;

        $stmt = $this->conn->prepare('SELECT note FROM reviews WHERE `idnc`=:idnc ORDER BY note DESC');
        $stmt->execute([
            ':idnc' => $idnc
        ]);

        $res = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        if ($res && count($res) > 0) {
            $stats->med = array_sum($res) / count($res);
            $stats->max = $res[0];
            $stats->min = $res[count($res) - 1];
            $stats->total = count($res);
        }

        return $stats;
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

    public function getAdmin(string $username): ?object {
        $admin = null;
        $stmt = $this->conn->prepare('SELECT * FROM admins WHERE `username`=:username');
        $stmt->execute([
            ':username' => $username
        ]);
        if ($stmt->rowCount() === 1) {
            $admin = $stmt->fetchObject();
        }
        return $admin;
    }

    public function getReports(): array {
        $reports = [];
        $query = $this->conn->query("SELECT reports.id, reports.reason, reviews.id, reviews.message FROM reports INNER JOIN reviews ON reviews.id = reports.review_id");
        if ($query) {
            $reports = $query->fetchAll(\PDO::FETCH_OBJ);
        }
        return $reports;
    }
}
