<?php
namespace app\models;

use Flight;
use PDO;

class venteModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPoidsMinAnimal($id){
        $sql = "SELECT poids_minimal_vente as poids FROM ELEVAGE_TYPEANIMAL WHERE id = $id";
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
        $poidsMin = $this->getPoidsMinAnimal($idAnimal);
        $prixParKg = $this->getPrixParKgAnimal($idAnimal); // Appel correct de la méthode
        return $poidsMin * $prixParKg;
    }

    public function getQuantiteAnimalUser($id,$user){
        $sql = "SELECT quantite from elevage_animal where utilisateur_id = $user AND id = $id";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch();
        return $result['quantite'];
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
            if (count($idAnimal) !== count($quantite)) {
                throw new Exception("Les tableaux 'id' et 'quantite' n'ont pas la même taille.");
            }
    
            for ($i = 0; $i < count($idAnimal); $i++) {
                $currentId = $idAnimal[$i];
                $currentQuantite = $quantite[$i];
                    echo $currentId;
                    echo $currentQuantite;

    
                //$prixAnimal = $this->getPrixAnimal($currentId);

    
                //$poids = $this->getPoidsActuel($currentId, $id_utilisateur);

    
                //$montantTotal = $prixAnimal * $currentQuantite;
    
    
                // $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite) 
                //          VALUES ('vente', :montant, :date, :utilisateur_id, :animal_id, :quantite)";
                // $stmt1 = $this->conn->prepare($sql1);
                // $stmt1->execute([
                //     ':montant' => $montantTotal,
                //     ':date' => $date,
                //     ':utilisateur_id' => $id_utilisateur,
                //     ':animal_id' => $currentId,
                //     ':quantite' => $currentQuantite
                // ]);
    
                // $this->updateQuantite($currentId, $id_utilisateur, $currentQuantite);
    
                // $this->updateCapitalUser($id_utilisateur, $montantTotal);
    
            }
    
            return true;
    }
    
}
?>