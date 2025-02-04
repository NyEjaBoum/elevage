<?php
namespace app\models;

use Flight;
use PDO;

class venteModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getType($id){
        $sql = "SELECT type_animal_id as types FROM ELEVAGE_ANIMAL WHERE id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['types'];
    }

    public function getPoidsMinAnimal($id){
        $sql = "SELECT poids_minimal_vente as poids FROM ELEVAGE_TYPEANIMAL WHERE id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['poids'];
    }

    public function getPoidsMaxAnimal($id){
        $sql = "SELECT poids_maximal as poids FROM ELEVAGE_TYPEANIMAL WHERE id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['poids'];
    }

    public function getPrixParKgAnimal($id){
        $sql = "SELECT prix_vente_kg as prix FROM ELEVAGE_TYPEANIMAL WHERE ID = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['prix'];
    }

    public function getPrixAnimal($idAnimal) {
        $id = $this->getType($idAnimal);
        $poidsMin = $this->getPoidsMinAnimal($id);
        $prixParKg = $this->getPrixParKgAnimal($id); // Appel correct de la méthode
        return $poidsMin * $prixParKg;
    }

    public function getQuantiteAnimalUser($id,$user){
        $sql = "SELECT quantite from elevage_animal where utilisateur_id = $user AND id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['quantite'];
    }

    public function getPourcentageGain($idFood){
        $sql = "SELECT pourcentage_gain_poids as prc from elevage_nourriture where id = $idFood";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['prc'];
    }

    public function getPoidsActuel($id,$user){
        $sql = "SELECT poids_actuel as poids from elevage_animal where utilisateur_id = $user AND id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['poids'];
    }

    public function updateCapitalUser($user, $prixVente) {
        try {
    
            $u = new UserModel(Flight::db());
            $newCap = $u->getCapitalUser($user) + $prixVente;
    
            $sql = "UPDATE elevage_utilisateur SET capital = :capital WHERE id = :utilisateur_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':capital' => $newCap,
                ':utilisateur_id' => $user
            ]);
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du capital de l'utilisateur : " . $e->getMessage();
        }
    }
    

    public function updateQuantite($idAnimal, $id_utilisateur, $quantite) {
        try {
    
            $quantiteActuelle = $this->getQuantiteAnimalUser($idAnimal, $id_utilisateur);
            $nouvelleQuantite = $quantiteActuelle - $quantite;
            if ($nouvelleQuantite < 0) {
                throw new Exception("Vous n'avez plus d'animaux");
            }
            $sqlUpdate = "UPDATE elevage_animal SET quantite = :quantite WHERE id = :animal_id AND utilisateur_id = :utilisateur_id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':quantite' => $nouvelleQuantite,
                ':animal_id' => $idAnimal,
                ':utilisateur_id' => $id_utilisateur
            ]);
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour de la quantité : " . $e->getMessage();
        }
    }
    
    public function venteAnimal($idAnimal, $id_utilisateur, $date, $quantite) {

    
                $currentId = $idAnimal;
                $currentQuantite = $quantite;

                $prixAnimal = $this->getPrixAnimal($currentId);
                $id = $this->getType($idAnimal);

                $poidMin = $this->getPoidsMinAnimal($id);
                $poidMax = $this->getPoidsMaxAnimal($id);
    
                $poids = $this->getPoidsActuel($currentId, $id_utilisateur);

                if($poids>=$poidMax || $poids<=$poidMin){
                    return false;
                }
    
                $montantTotal = $prixAnimal * $currentQuantite;
    
    
                $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite) 
                         VALUES ('vente', :montant, :date, :utilisateur_id, :animal_id, :quantite)";
                $stmt1 = $this->conn->prepare($sql1);
                $stmt1->execute([
                    ':montant' => $montantTotal,
                    ':date' => $date,
                    ':utilisateur_id' => $id_utilisateur,
                    ':animal_id' => $currentId,
                    ':quantite' => $currentQuantite
                ]);
    
                $this->updateQuantite($currentId, $id_utilisateur, $currentQuantite);
    
                $this->updateCapitalUser($id_utilisateur, $montantTotal);
    
            
    
            return true;
    }

    public function checkAutoVente($animalId) {
        $sql = "SELECT a.*, t.poids_minimal_vente 
                FROM elevage_animal a 
                JOIN elevage_typeAnimal t ON a.type_animal_id = t.id 
                WHERE a.id = :animal_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':animal_id' => $animalId]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$animal) {
            return false;
        }
        
        return $animal['poids_actuel'] >= $animal['poids_minimal_vente'];
    }

    public function checkAutoVenteStatus($animalId) {
        $sql = "SELECT autoVente 
                FROM elevage_animal 
                WHERE id = :animal_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':animal_id' => $animalId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            return false;
        }
        
        return (bool)$result['autoVente'];
    }
    
    public function getAnimalDetails($animalId) {
        $sql = "SELECT a.*, t.poids_minimal_vente, t.prix_vente_kg 
                FROM elevage_animal a 
                JOIN elevage_typeAnimal t ON a.type_animal_id = t.id 
                WHERE a.id = :animal_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':animal_id' => $animalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function venteAnimale($idAnimal, $id_utilisateur, $date, $quantite) {
            $this->conn->beginTransaction();

            // Vérifier si l'animal est en autovente et a atteint le poids minimal
            if ($this->checkAutoVente($idAnimal)) {
                $poidsMin = $this->getPoidsMinAnimal($idAnimal);
                $prixParKg = $this->getPrixParKgAnimal($idAnimal);
                $prixAnimal = $poidsMin * $prixParKg;
            } else {
                $prixParKg = $this->getPrixParKgAnimal($idAnimal);
                $poids = $this->getPoidsActuel($idAnimal, $id_utilisateur);
                $prixAnimal = $poids * $prixParKg;
            }

            $montantTotal = $prixAnimal * $quantite;

            // Enregistrer la transaction
            $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite) 
                     VALUES ('vente', :montant, :date, :utilisateur_id, :animal_id, :quantite)";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute([
                ':montant' => $montantTotal,
                ':date' => $date,
                ':utilisateur_id' => $id_utilisateur,
                ':animal_id' => $idAnimal,
                ':quantite' => $quantite
            ]);

            // Mettre à jour les quantités
            $this->updateQuantite($idAnimal, $id_utilisateur, $quantite);
            
            // Mettre à jour le capital
            $this->updateCapitalUser($id_utilisateur, $montantTotal);

            $this->conn->commit();
            return true;

        }

        public function planifierVenteAnimal($animalId, $userId, $datePrevue, $quantite = 1) {
            try {
                $sql = "INSERT INTO elevage_vente_planifiee (animal_id, utilisateur_id, date_prevue, quantite) 
                        VALUES (:animal_id, :user_id, :date_prevue, :quantite)";
                
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':animal_id' => $animalId,
                    ':user_id' => $userId,
                    ':date_prevue' => $datePrevue,
                    ':quantite' => $quantite
                ]);
            } catch (PDOException $e) {
                return false;
            }
        }
}

?>