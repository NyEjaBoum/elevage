<?php

namespace app\models;

use Flight;
use PDO;

class AchatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertAnimal($nom, $poids_actuel, $date_achat, $est_vivant, $id_utilisateur ,$type_animal_id) {
            $sql = "INSERT INTO elevage_animal (nom, poids_actuel, date_achat, est_vivant, utilisateur_id, type_animal_id) 
                    VALUES (:nom, :poids_actuel, :date_achat, :est_vivant, :id_utilisateur, :type_animal_id)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':poids_actuel' => $poids_actuel,
                ':date_achat' => $date_achat,
                ':est_vivant' => $est_vivant,
                ':utilisateur_id' => $id_utilisateur,
                ':type_animal_id' => $type_animal_id
            ]);
            
            return $this->db->lastInsertId();
    }
}