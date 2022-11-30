<?php
namespace App\Items;

class Review extends BaseItem {
    public function getAll(): array {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes FROM reviews');
        $success = $stmt->execute();

        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function getAllFromIdnc(string $idnc): array {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes FROM reviews WHERE `idnc`=:idnc');
        $success = $stmt->execute([
            ':idnc' => $idnc
        ]);

        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function get(int $id): ?object {
        $stmt = $this->conn->prepare('SELECT id, username, note, `message`, votes FROM reviews WHERE `id`=:id LIMIT 1');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success ? $stmt->fetchObject() : null;
    }

    public function add(string $idnc, string $username, float $note, string $message): bool {
        $stmt = $this->conn->prepare('INSERT INTO reviews (idnc, username, note, `message`) VALUES (:idnc, :username, :note, :message)');
        $success = $stmt->execute([
            ':idnc' => $idnc,
            ':username' => $username,
            ':note' => $note,
            ':message' => $message
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

    public function statsOne(string $idnc): object {
        $stats = new \stdClass;
        $stats->med = 0;
        $stats->min = 0;
        $stats->max = 0;
        $stats->total = 0;

        $stmt = $this->conn->prepare('SELECT note FROM reviews WHERE `idnc`=:idnc ORDER BY note DESC');
        $success = $stmt->execute([
            ':idnc' => $idnc
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

    public function statsAll(): object {
        $stats = new \stdClass;
        $stats->total = 0;
        $stats->med = 0;

        $stmt = $this->conn->prepare('SELECT note FROM reviews');
        $success = $stmt->execute();
        if ($success) {
            $res = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            if (count($res) > 0) {
                $stats->med = round(array_sum($res) / count($res), 2);
                $stats->total = count($res);
            }
        }

        return $stats;
    }

    public function vote(int $id, bool $more = false): bool {
        $change = $more ? 1 : -1;

        $stmt = $this->conn->prepare("UPDATE reviews SET votes = (votes + :change) WHERE id=:id");
        $success = $stmt->execute([
            ':id' => $id,
            ':change' => $change
        ]);
        return $success;
    }
}
