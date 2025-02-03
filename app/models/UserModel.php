<?php
namespace app\models;

use Flight;
use PDO;

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($nom) {
        $stmt = $this->conn->prepare("SELECT * FROM elevage_utilisateur WHERE nom = ?");
        $stmt->execute([$nom]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function signin($nom){
        $stmt = $this->conn->prepare("INSERT INTO elevage_utilisateur (nom,capital) VALUES (?,0)");
        $stmt->execute([$nom]);
    }
}
?>