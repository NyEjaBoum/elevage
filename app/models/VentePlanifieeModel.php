<?php
namespace app\models;

use PDO;

class VentePlanifieeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getVentesPlanifiees($userId) {
        $sql = "SELECT vp.*, a.nom as nom_animal, a.poids_actuel, t.poids_minimal_vente, t.prix_vente_kg
                FROM elevage_vente_planifiee vp
                JOIN elevage_animal a ON vp.animal_id = a.id
                JOIN elevage_typeAnimal t ON a.type_animal_id = t.id
                WHERE vp.utilisateur_id = :user_id AND vp.est_execute = FALSE
                ORDER BY vp.date_prevue ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>