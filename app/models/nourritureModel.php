<?php

namespace app\models;
use Flight;

use PDO;
use PDOException;

class nourritureModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllNourritureUserForAnimal($utilisateur_id, $type_animal_id) {
            $sql = "
                SELECT 
                    n.id AS nourriture_id,
                    n.nom AS nourriture_nom,
                    n.pourcentage_gain_poids,
                    n.prix_kg,
                    s.quantite AS stock_utilisateur
                FROM 
                    elevage_nourriture n
                JOIN 
                    elevage_stockUtilisateur s ON n.id = s.idNourriture
                WHERE 
                    s.utilisateur_id = :utilisateur_id
                    AND n.type_animal_id = :type_animal_id;
            ";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':utilisateur_id' => $utilisateur_id,
                ':type_animal_id' => $type_animal_id
            ]);
    
            $nourritures = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $nourritures;
            
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
        $stmt = $this->db->prepare("
            SELECT 
                a.id,
                a.nom,
                a.poids_actuel,
                a.date_achat,
                a.est_vivant,
                a.utilisateur_id,
                a.type_animal_id,
                a.quantite,
                a.quota_nourriture_journalier
            FROM elevage_animal a 
            WHERE a.utilisateur_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getQuantiteStock($userId, $idFood) {
        $stmt = $this->db->prepare("SELECT quantite FROM elevage_stockUtilisateur WHERE utilisateur_id = ? AND idNourriture = ?");
        $stmt->execute([$userId, $idFood]);
        $result = $stmt->fetch();
        return $result ? $result['quantite'] : 0; 
    }
    

    public function getPrixNourriture($idFood) {
        $stmt = $this->db->prepare("SELECT prix_kg as prix FROM elevage_nourriture WHERE id = ?");
        $stmt->execute([$idFood]);
        $result = $stmt->fetch();
        return $result['prix']; 
    }
    
    public function updateStockUtilisateur($userId, $idFood, $quantite) {
        $currentQuantity = $this->getQuantiteStock($userId, $idFood);
        $v = new venteModel(Flight::db());

        if ($currentQuantity == 0) {
            $stmt = $this->db->prepare("INSERT INTO elevage_stockUtilisateur (utilisateur_id, idNourriture, quantite) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $idFood, $quantite]);
        } else {
            $stmt = $this->db->prepare("UPDATE elevage_stockUtilisateur SET quantite = quantite + ? WHERE utilisateur_id = ? AND idNourriture = ?");
            $stmt->execute([$quantite, $userId, $idFood]);
        }
        $prixKg = $this->getPrixNourriture($idFood);
        $newCapital = $prixKg * $quantite;
        $up = $v->updateCapitalUser($userId,-$newCapital);
    }

    

    public function updatePoidsAnimal($userId,$idAnimal,$newPoids){
        $stmt = $this->db->prepare("UPDATE elevage_animal SET poids_actuel = ? WHERE idAnimal =? AND utilisateur_id = ?");
        $stmt->execute([$newPoids,$idAnimal,$userId]);
    }

    public function getAnimalById($idAnimal){
        $sql = "SELECT * FROM elevage_animal WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idAnimal]);
        return $stmt->fetch(PDO::FETCH_OBJ); // Changé en FETCH_OBJ au lieu de FETCH_ASSOC
    }

    public function nourrir($userId, $idNourriture, $idAnimal, $quantite) {
        // Mettre à jour le poids de l'animal
        $v = new venteModel(Flight::db());
        $poidsActuel = $v->getPoidsActuel($idAnimal, $userId);
        $pourcGain = $v->getPourcentageGain($idNourriture);
    
        $newPoids = $poidsActuel + ($poidsActuel * ($pourcGain / 100) * $quantite);
        $this->updatePoidsAnimal($userId, $idAnimal, $newPoids);
    
        // Réduire le stock de la nourriture spécifique
        $this->updateStockUtilisateur($userId, $idNourriture, -$quantite);
    }



    public function nourrirAnimauxAutomatiquement($userId) {
        // Récupérer tous les animaux de l'utilisateur
        $animaux = $this->getAnimalsByUser($userId);
    
        // Trier les animaux par priorité (proches de la vente en premier)
        $animaux = $this->trierAnimauxParPriorite($animaux);
    
        foreach ($animaux as $animal) {
            $quota = $animal->quota_nourriture_journalier;
            $idNourriture = $animal->idNourriture;
    
            // Récupérer le stock de la nourriture spécifique à cet animal
            $stockDisponible = $this->getQuantiteStock($userId, $idNourriture);
    
            // Vérifier si le stock est suffisant pour nourrir cet animal
            if ($stockDisponible >= $quota) {
                // Nourrir l'animal
                $this->nourrir($userId, $idNourriture, $animal->idAnimal, $quota);
            } else {
                // Pas assez de nourriture pour nourrir cet animal
                // Passer à l'animal suivant
                continue;
            }
        }
    }
    
    private function trierAnimauxParPriorite($animaux) {
        $v = new venteModel(); // Assurez-vous que cette classe est correctement initialisée
    
        usort($animaux, function($a, $b) use ($v) {
            // Calculer la distance au poids minimal de vente pour chaque animal
            $distanceA = abs($a->poids_actuel - $v->getPoidsMinAnimal($a->type_animal_id));
            $distanceB = abs($b->poids_actuel - $v->getPoidsMinAnimal($b->type_animal_id));
    
            // Prioriser les animaux les plus proches du poids de vente
            return $distanceA <=> $distanceB;
        });
    
        return $animaux;
    }

    public function simulerAnimal($userId, $idAnimal, $dateSimulation) {
        // Récupérer les informations de l'animal
        $animal = $this->getAnimalById($idAnimal);
    
        if (!$animal) {
            return [
                'idAnimal' => $idAnimal,
                'erreur' => 'Animal non trouvé'
            ];
        }
    
        // Récupérer le type d'animal pour avoir les informations de vente
        $v = new venteModel(Flight::db());
        $poidsMinimalVente = $v->getPoidsMinAnimal($animal->type_animal_id);
    
        // Calculer le nombre de jours entre la date actuelle et la date de simulation
        $dateActuelle = date('Y-m-d');
        $joursSimulation = (strtotime($dateSimulation) - strtotime($dateActuelle)) / (60 * 60 * 24);
    
        // Initialiser les résultats
        $resultat = [
            'idAnimal' => $idAnimal,
            'nom' => $animal->nom,
            'poids_actuel' => $animal->poids_actuel,
            'nourriture_consommee' => 0,
            'statut' => $animal->est_vivant ? 'En vie' : 'Mort'
        ];
    
        // Simuler chaque jour jusqu'à la date de simulation
        for ($i = 0; $i < $joursSimulation; $i++) {
            // Vérifier si l'animal est mort
            if (!$animal->est_vivant) {
                $resultat['statut'] = 'Mort';
                break;
            }
    
            // Vérifier si l'animal est vendable
            if ($animal->poids_actuel >= $poidsMinimalVente) {
                $resultat['statut'] = 'Prêt à vendre';
                break;
            }
    
            // Récupérer les nourritures disponibles pour ce type d'animal
            $nourritures = $this->getAllNourritureUserForAnimal($userId, $animal->type_animal_id);
    
            if (empty($nourritures)) {
                $resultat['statut'] = 'Pas de nourriture disponible';
                break;
            }
    
            // Prendre la première nourriture disponible
            $nourriture = $nourritures[0];
    
            // Vérifier le quota et le stock
            $quota = $animal->quota_nourriture_journalier;
            $stockDisponible = $this->getQuantiteStock($userId, $nourriture['nourriture_id']);
    
            if ($stockDisponible >= $quota) {
                // Simuler le nourrissage
                $poidsGagne = ($animal->poids_actuel * ($nourriture['pourcentage_gain_poids'] / 100) * $quota);
                $animal->poids_actuel += $poidsGagne;
    
                // Mettre à jour les résultats
                $resultat['nourriture_consommee'] += $quota;
                $resultat['poids_actuel'] = $animal->poids_actuel;
    
                // Réduire le stock de nourriture
                $this->updateStockUtilisateur($userId, $nourriture['nourriture_id'], -$quota);
            } else {
                // Pas assez de nourriture
                $resultat['statut'] = 'Stock insuffisant';
                break;
            }
        }
    
        return $resultat;
    }
    
}
?>