<?php
namespace App\Items;

class User extends BaseItem {
    public function add(string $niu, string $password): bool {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare('INSERT INTO users(niu, password) VALUES(:niu, :password)');
        $success = $stmt->execute([
            ':niu' => $niu,
            ':password' => $password_hashed
        ]);
        return $success;
    }

    public function get(string $niu): ?object {
        $stmt = $this->conn->prepare('SELECT id, niu, `password`, `admin` FROM users WHERE `niu`=:niu');
        $stmt->execute([
            ':niu' => $niu
        ]);
        $niu = $stmt->fetch(\PDO::FETCH_OBJ);
        return $niu !== false ? $niu : null;
    }
}
