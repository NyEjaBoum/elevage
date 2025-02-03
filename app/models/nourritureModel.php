<?php

namespace app\models;

use PDO;
use PDOException;

class nourritureModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getFoodsByUser($userId) {
            $stmt = $this->db->prepare("SELECT * FROM elevage_nourriture WHERE utilisateur_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalsByUser($userId) {
            $stmt = $this->db->prepare("SELECT * FROM elevage_animal WHERE utilisateur_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

//     public function getFoodPurchaseHistoryByUser($userId) {
//             $stmt = $this->db->prepare("SELECT * FROM food_purchase_history WHERE utilisateur_id = ?");
//             $stmt->execute([$userId]);
//             return $stmt->fetchAll(PDO::FETCH_OBJ);
// }
}
?>