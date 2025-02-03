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

    /**
     * Récupère tous les animaux d'un utilisateur spécifique.
     *
     * @param int $utilisateur_id L'ID de l'utilisateur.
     * @return array|false Liste des animaux de l'utilisateur ou false en cas d'erreur.
     */
    public function getAnimauxByUtilisateur($utilisateur_id) {
        try {
            $sql = "SELECT ea.*, et.nom AS type_animal_nom 
                    FROM elevage_animal ea
                    JOIN elevage_typeAnimal et ON ea.type_animal_id = et.id
                    WHERE ea.utilisateur_id = :utilisateur_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            return false;
        }
    }
}