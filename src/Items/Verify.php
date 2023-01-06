<?php
namespace App\Items;

class Verify extends BaseItem {
    public function add(string $niu, string $code): bool {
        $stmt = $this->conn->prepare('INSERT INTO verify(niu, code) VALUES(:niu, :code)');
        $success = $stmt->execute([
            ':niu' => $niu,
            ':code' => $code
        ]);
        return $success;
    }

    public function get(string $code): ?object {
        $stmt = $this->conn->prepare('SELECT id, `niu`, code FROM verify WHERE `code`=:code');
        $stmt->execute([
            ':code' => $code
        ]);
        $new_user = $stmt->fetch(\PDO::FETCH_OBJ);
        return $new_user !== false ? $new_user : null;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare('DELETE FROM verify WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success;
    }

    public function update(string $niu, string $code): bool {
        $stmt = $this->conn->prepare('UPDATE verify SET code=:code WHERE niu=:niu');
        $success = $stmt->execute([
            ':niu' => $niu,
            ':code' => $code
        ]);
        return $success;
    }

    public function exists(string $niu): bool {
        $stmt = $this->conn->prepare('SELECT 1 from verify WHERE niu=:niu LIMIT 1');
        $stmt->execute([
            ':niu' => $niu
        ]);

        if($stmt->fetchColumn()) {
            return true;
        }
        return false;
    }
}
