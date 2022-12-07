<?php
namespace App\Items;

use App\Helpers\Misc;

class Review extends BaseItem {
    const PER_PAGE = 10;

    public function getAll(): array {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes, `subject` FROM reviews');
        $success = $stmt->execute();

        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function getAllFrom(string $to, int $page = 1, string $sort = "created_at", string $order = "asc"): array {
        $isValidSort = Misc::sanitizeSort($sort, $order);
        if ($isValidSort) {
            $offset = $this->__calcOffset($page);
            $per = self::PER_PAGE;
            $stmt = $this->conn->prepare("SELECT id, username, note, `message`, votes FROM reviews WHERE `to`=:to ORDER BY $sort $order LIMIT $offset,$per");
            $success = $stmt->execute([
                ':to' => $to
            ]);
            return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
        }

        return [];
    }

    public function get(int $id): ?object {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes FROM reviews WHERE `id`=:id LIMIT 1');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success ? $stmt->fetchObject() : null;
    }

    public function add(string $to, string $username, float $note, string $message, int $subject): bool {
        $stmt = $this->conn->prepare('INSERT INTO reviews (`to`, username, note, `message`, `subject`) VALUES (:to, :username, :note, :message, :subject)');
        $success = $stmt->execute([
            ':to' => $to,
            ':username' => $username,
            ':note' => $note,
            ':message' => $message,
            ':subject' => $subject
        ]);
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare('DELETE FROM reviews WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success;
    }

    public function statsOne(string $to): object {
        $stats = new \stdClass;
        $stats->med = 0;
        $stats->min = 0;
        $stats->max = 0;
        $stats->total = 0;

        $stmt = $this->conn->prepare('SELECT note FROM reviews WHERE `to`=:to ORDER BY note DESC');
        $success = $stmt->execute([
            ':to' => $to
        ]);

        if ($success) {
            $res = $stmt->fetchAll(\PDO::FETCH_COLUMN);

            if (count($res) > 0) {
                $stats->med = round(array_sum($res) / count($res), 1);
                $stats->max = $res[0];
                $stats->min = $res[count($res) - 1];
                $stats->total = count($res);
            }
        }

        return $stats;
    }

    public function statsTotal(): array {
        $stats = [];

        $query = $this->conn->query('SELECT COUNT(note) AS `total`, AVG(note) AS med FROM reviews GROUP BY `subject`');

        if ($query) {
            $stats = $query->fetchAll(\PDO::FETCH_OBJ);
        }

        return $stats;
    }

    public function vote(int $id, bool $more = false): bool {
        $stmt = $this->conn->prepare("UPDATE reviews SET votes = (votes + :change) WHERE id=:id");
        $success = $stmt->execute([
            ':id' => $id,
            ':change' => intval($more)
        ]);
        return $success;
    }

    private function __calcOffset(int $page): int {
        return self::PER_PAGE * ($page - 1);
    }
}
