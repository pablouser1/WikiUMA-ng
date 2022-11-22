<?php
namespace App\Items;

use App\Helpers\Wrappers;

abstract class BaseItem {
    protected \PDO $conn;

    function __construct(?\PDO $client = null) {
        if ($client) {
            $this->conn = $client;
        } else {
            $db = Wrappers::db();
            $this->conn = $db;
        }
    }
}
