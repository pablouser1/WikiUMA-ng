<?php
namespace App\Items;

class Tag extends BaseItem {
    public function add(string $name, int $type): bool {
        $stmt = $this->conn->prepare('INSERT INTO tags (`name`, `type`) VALUES (:name, :type)');
        $success = $stmt->execute([
            ':name' => $name,
            ':type' => $type
        ]);
        return $success;
    }

    public function edit(int $id, string $name, string $type): bool {
        $stmt = $this->conn->prepare('UPDATE tags SET `name`=:name, `type`=:type WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':type' => $type
        ]);
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare('DELETE FROM tags WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success;
    }

    public function getAll(): array {
        $sql = <<<SQL
        SELECT
            `id`,
            `name`,
            `type`
        FROM
            tags
        SQL;
        $query = $this->conn->query($sql);
        return $query !== false ? $query->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function getFrom(int $id): array {
        $sql = <<<SQL
        SELECT
            t.id,
            t.name,
            t.type
        FROM
            reviews_tags rt
        INNER JOIN
            tags t
        ON
            rt.tag_id=t.id
        WHERE
            rt.review_id=:id
        SQL;
        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }
}
