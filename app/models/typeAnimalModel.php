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

    public function updateType($ids, $noms, $poidsMins, $poidsMaxs, $prixVenteKgs, $jours, $pourcentages) {
        try {
            // Parcourir chaque ligne
            for ($i = 0; $i < count($ids); $i++) {
                $id = $ids[$i];
                $nom = $noms[$i];
                $poidsMin = $poidsMins[$i];
                $poidsMax = $poidsMaxs[$i];
                $prixVenteKg = $prixVenteKgs[$i];
                $jour = $jours[$i];
                $pourcentage = $pourcentages[$i];
                $sql = "UPDATE elevage_typeAnimal 
                        SET nom = '$nom', 
                            poids_minimal_vente = $poidsMin, 
                            poids_maximal = $poidsMax, 
                            prix_vente_kg = $prixVenteKg, 
                            jours_sans_manger = $jour, 
                            pourcentage_perte_poids = $pourcentage 
                        WHERE id = $id"; 
    
                $stmt = $this->conn->exec($sql);
    
                if ($stmt > 0) {
                    echo "Mise à jour réussie pour l'id $id<br>";
                } else {
                    echo "Aucune ligne mise à jour pour l'id $id<br>";
                }
            }
    
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }
    
    

    /*public function updateType($id, $nom, $poidsMin, $poidsMax, $prixVenteKg, $jour, $pourcentage) {
        $columns = [];
        $values = [];
    
        if ($nom !== null) {
            $columns[] = 'nom = ?';
            $values[] = $nom;
        }
        if ($poidsMin !== null) {
            $columns[] = 'poids_minimal_vente = ?';
            $values[] = $poidsMin;
        }
        if ($poidsMax !== null) {
            $columns[] = 'poids_maximal = ?';
            $values[] = $poidsMax;
        }
        if ($prixVenteKg !== null) {
            $columns[] = 'prix_vente_kg = ?';
            $values[] = $prixVenteKg;
        }
        if ($jour !== null) {
            $columns[] = 'jours_sans_manger = ?';
            $values[] = $jour;
        }
        if ($pourcentage !== null) {
            $columns[] = 'pourcentage_perte_poids = ?';
            $values[] = $pourcentage;
        }
    
        if (empty($columns)) {
            return false;
        }
        $sql = "UPDATE elevage_typeAnimal SET " . implode(', ', $columns) . " WHERE id = ?";
        $values[] = $id; 
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($values);
        return $stmt->rowCount();
    }*/

    

}
?>