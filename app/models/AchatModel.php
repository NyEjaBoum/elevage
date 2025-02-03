<?php

namespace app\models;

use Flight;
use PDO;

class AchatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function Useelevage_animal($id) {
        // Utilisez prepare au lieu de query pour éviter les injections SQL
        $stmt = $this->db->prepare("SELECT * FROM elevage_animal WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LesAchat($id) {
        // Récupérez les données de l'animal
        $data = $this->Useelevage_animal($id);

        // Vérifiez si des données ont été trouvées
        if (!empty($data)) {
            // Accédez au premier élément du tableau
            $animal = $data[0];

            // Requête SQL pour insérer les données dans la table elevage_animal_for_Achat
            $query = "INSERT INTO `elevage_animal_for_Achat` (image, nom, poids_actuel, date_achat, est_vivant, utilisateur_id, type_animal_id) 
                      VALUES (:image, :nom, :poids_actuel, :date_achat, :est_vivant, :utilisateur_id, :type_animal_id)";
            $stmt = $this->db->prepare($query);

            // Exécutez la requête avec les données de l'animal
            return $stmt->execute([
                ':image'          => $animal['image'],
                ':nom'            => $animal['nom'],
                ':poids_actuel'   => $animal['poids_actuel'],
                ':date_achat'     => $animal['date_achat'],
                ':est_vivant'     => $animal['est_vivant'],
                ':utilisateur_id' => $animal['utilisateur_id'],
                ':type_animal_id' => $animal['type_animal_id']
            ]);
        }

        // Retourne false si aucune donnée n'a été trouvée
        return false;
    }
}