<?php
namespace App\Items;

class Tag extends BaseItem {
    public function add(string $name, int $type, ?string $icon = null): bool {
        $stmt = $this->conn->prepare('INSERT INTO tags (`name`, `type`, `icon`) VALUES (:name, :type, :icon)');
        $success = $stmt->execute([
            ':name' => $name,
            ':type' => $type,
            ':icon' => $icon
        ]);
        return $success;
    }

    public function edit(int $id, string $name, string $type, ?string $icon = null): bool {
        $stmt = $this->conn->prepare('UPDATE tags SET `name`=:name, `type`=:type, `icon`=:icon WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':type' => $type,
            ':icon' => $icon
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
            `type`,
            `icon`
        FROM
            tags
        ORDER BY `type` DESC
        SQL;
        $query = $this->conn->query($sql);
        return $query !== false ? $query->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function getFrom(int $id): array {
        $sql = <<<SQL
        SELECT
            t.id,
            t.name,
            t.type,
            t.icon
        FROM
            reviews_tags rt
        INNER JOIN
            tags t
        ON
            rt.tag_id=t.id
        WHERE
            rt.review_id=:id
        ORDER BY t.type DESC
        SQL;
        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }

    public function statsOne(string $data): array {
        $sql = <<<SQL
        SELECT
            t.id,
            t.name,
            t.type,
            t.icon
        FROM
            reviews r
        INNER JOIN
            reviews_tags rt
        ON
            r.id=rt.review_id
        INNER JOIN
            tags t
        ON
            rt.tag_id=t.id
        WHERE
            r.data=:data
        GROUP BY
            rt.tag_id
        ORDER BY
            COUNT(rt.tag_id) DESC
        LIMIT 3
        SQL;
        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([
            ':data' => $data
        ]);
        return $success ? $stmt->fetchAll(\PDO::FETCH_OBJ) : [];
    }
}
