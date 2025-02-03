<?php
namespace app\models;

use Flight;
use PDO;

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($nom,$mdp) {
        $stmt = $this->conn->prepare("SELECT * FROM elevage_utilisateur WHERE nom = ? AND mdp = ?");
        $stmt->execute([$nom,$mdp]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function signin($nom,$mdp){
        $stmt = $this->conn->prepare("INSERT INTO elevage_utilisateur (nom,mdp,capital) VALUES (?,?,0)");
        $stmt->execute([$nom,$mdp]);
    }
}
?>