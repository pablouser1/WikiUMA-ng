<?php
namespace App\Items;

class Report extends BaseItem {
    public function getAll(): array {
        $reports = [];
        $query = $this->conn->query("SELECT reports.id AS reportId, reports.reason, reviews.id AS reviewId, reviews.username, reviews.message, reviews.note, reviews.votes FROM reports INNER JOIN reviews ON reviews.id = reports.review_id");
        if ($query) {
            $reports = $query->fetchAll(\PDO::FETCH_OBJ);
        }
        return $reports;
    }

    public function add(int $review_id, string $reason): bool {
        $stmt = $this->conn->prepare('INSERT INTO reports (review_id, reason) VALUES (:review_id, :reason)');
        $success = $stmt->execute([
            ':review_id' => $review_id,
            ':reason' => $reason
        ]);
        return $success;
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare('DELETE FROM reports WHERE id=:id');
        $success = $stmt->execute([
            ':id' => $id
        ]);
        return $success;
    }
}
