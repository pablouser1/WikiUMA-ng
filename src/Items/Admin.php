<?php
namespace App\Items;

class Admin extends BaseItem {
    public function get(string $username): ?object {
        $stmt = $this->conn->prepare('SELECT id, username, `password` FROM admins WHERE `username`=:username');
        $stmt->execute([
            ':username' => $username
        ]);
        $admin = $stmt->fetch(\PDO::FETCH_OBJ);
        return $admin !== false ? $admin : null;
    }
}
