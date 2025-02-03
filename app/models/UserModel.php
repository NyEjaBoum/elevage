<?php
namespace app\models;

use Flight;
use PDO;

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $mdp) {
        $stmt = $this->conn->prepare("SELECT * FROM immo_utilisateur WHERE email = ? AND mdp = ?");
        $stmt->execute([$email, $mdp]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function signin($email,$nom,$mdp,$tel){
        $stmt = $this->conn->prepare("INSERT INTO immo_utilisateur (nom,email,mdp,numero) VALUES (?,?,?,?)");
        $stmt->execute([$nom,$email,$mdp,$tel]);
    }
}
?>