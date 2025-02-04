<?php

namespace app\models;

use PDO;
use PDOException;

class AcheterAnimalModel
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimalsByUser()
    {
        // Modifie la requête pour exclure les animaux de l'utilisateur courant
        $sql = "SELECT a.*, t.prix_vente_kg 
                FROM elevage_animal a 
                JOIN elevage_typeAnimal t ON a.type_animal_id = t.id 
                WHERE a.utilisateur_id != :user_id";  // Ajoute cette condition

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $_SESSION['user']
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
