<?php

namespace app\models;

use PDO;
use PDOException;

class nourritureModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function achatNourriture($userId,$idNourriture){
        $sql = "INSERT INTO elevage_stockUtilisateur (idNourriture,utilisateur_id) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idNourriture,$userId]);
    }

    public function getAllFoods($idAnimal) {
        $stmt = $this->db->query("SELECT * FROM elevage_nourriture");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFoodsByUser($userId) {
            $stmt = $this->db->prepare("SELECT n.nom as nom,n.pourcentage_gain_poids as prc,prix_kg as prix FROM elevage_stockUtilisateur s JOIN elevage_nourriture n on n.id = s.idNourriture WHERE utilisateur_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalsByUser($userId) {
            $stmt = $this->db->prepare("SELECT * FROM elevage_animal WHERE utilisateur_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getQuantiteStock($userId, $idFood) {
        $stmt = $this->db->prepare("SELECT quantite FROM elevage_stockUtilisateur WHERE utilisateur_id = ? AND idNourriture = ?");
        $stmt->execute([$userId, $idFood]);
        $result = $stmt->fetch();
        return $result ? $result['quantite'] : 0; 
    }
    
    public function updateStockUtilisateur($userId, $idFood, $quantite) {
        $currentQuantity = $this->getQuantiteStock($userId, $idFood);
    
        if ($currentQuantity === 0) {
            $stmt = $this->db->prepare("INSERT INTO elevage_stockUtilisateur (utilisateur_id, idNourriture, quantite) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $idFood, $quantite]);
        } else {
            $stmt = $this->db->prepare("UPDATE elevage_stockUtilisateur SET quantite = quantite + ? WHERE utilisateur_id = ? AND idNourriture = ?");
            $stmt->execute([$quantite, $userId, $idFood]);
        }
    }
    

//     public function getFoodPurchaseHistoryByUser($userId) {
//             $stmt = $this->db->prepare("SELECT * FROM food_purchase_history WHERE utilisateur_id = ?");
//             $stmt->execute([$userId]);
//             return $stmt->fetchAll(PDO::FETCH_OBJ);
// }
}
?>