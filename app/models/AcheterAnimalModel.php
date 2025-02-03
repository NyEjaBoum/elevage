<?php

namespace app\models;

use PDO;
use PDOException;

class AcheterAnimalModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAnimalsByUser() {
            $stmt = $this->db->prepare("SELECT * FROM elevage_animal group by utilisateur_id");
            $stmt->execute();
            return $stmt->fetchAll();
    }
}
?>