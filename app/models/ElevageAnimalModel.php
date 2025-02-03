<?php

namespace app\models;

use Flight;
use PDO;
use PDOException;

class ElevageAnimalModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAnimauxByUtilisateur($utilisateur_id) {
            $sql = "SELECT ea.*, et.nom AS type_animal_nom 
                    FROM elevage_animal ea
                    JOIN elevage_typeAnimal et ON ea.type_animal_id = et.id
                    WHERE ea.utilisateur_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$utilisateur_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}