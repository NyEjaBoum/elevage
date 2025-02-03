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
        $sql= ("SELECT * FROM elevage_utilisateur WHERE nom = '$nom' AND mdp = '$mdp'");
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function signin($nom,$mdp){
        $stmt = $this->conn->prepare("INSERT INTO elevage_utilisateur (nom,mdp,capital) VALUES (?,?,0)");
        $stmt->execute([$nom,$mdp]);
    }

    public function getCapitalUser($user){
        $sql = "SELECT capital FROM elevage_utilisateur where id = $user";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['capital'];
    }
    
    public function getAffichageAchate(){
        $sql = "SELECT * FROM elevage_animal";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>