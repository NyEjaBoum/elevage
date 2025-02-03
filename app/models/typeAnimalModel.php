<?php
namespace app\models;

use Flight;
use PDO;

class typeAnimalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllType($nom,$mdp) {
        $sql = "SELECT * FROM elevage_typeAnimal";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>