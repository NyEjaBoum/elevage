<?php
namespace app\models;

use Flight;
use PDO;

class typeAnimalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllType() {
        $sql = "SELECT * FROM elevage_typeAnimal";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createType($nom,$poidsMin,$poidsMax,$prixVenteKg,$jour,$pourcentage){
        $sql = "INSERT INTO elevage_typeAnimal (nom,poids_minimal_vente,poids_maximal,prix_vente_kg,jours_sans_manger,pourcentage_perte_poids)
        VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom,$poidsMin,$poidsMax,$prixVenteKg,$jour,$pourcentage]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateType($id, $nom, $poidsMin, $poidsMax, $prixVenteKg, $jour, $pourcentage) {
        $sql = "UPDATE elevage_typeAnimal 
                SET nom = ?, 
                    poids_minimal_vente = ?, 
                    poids_maximal = ?, 
                    prix_vente_kg = ?, 
                    jours_sans_manger = ?, 
                    pourcentage_perte_poids = ? 
                WHERE id = ?"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $poidsMin, $poidsMax, $prixVenteKg, $jour, $pourcentage, $id]);
        return $stmt->rowCount();
    }

}
?>