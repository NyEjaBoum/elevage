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
        $sql = "SELECT poids_minimal_vente as poids FROM ELEVAGE_TYPEANIMAL WHERE ID = $id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['poids'];
    }

    public function getPrixParKgAnimal($id){
        $sql = "SELECT prix_vente_kg as prix FROM ELEVAGE_TYPEANIMAL WHERE ID = $id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['prix'];
    }

    public function getPrixAnimal($id){
        $poids = $this->getPoidsMinAnimal($id);
        $prixParKg = $this->getPrixAnimal($id);
        $prix = $poids*$prixParKg;
        return $prix;
    }

    public function getQuantiteAnimalUser($id,$user){
        $sql = "SELECT quantite from elevage_animal where utilisateur_id = $user AND id = $id";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['quantite'];
    }

    public function updateCapitalUser($user,$capital){
        
    }

    public function updateQuantite($idAnimal, $id_utilisateur, $quantite) {
        try {
    
            $quantiteActuelle = $this->getQuantiteAnimalUser($idAnimal, $id_utilisateur);
            $nouvelleQuantite = $quantiteActuelle + $quantite;
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
    

    public function venteAnimal($idAnimal,$id_utilisateur,$date,$quantite){
        // transcation
        //table animal
        $montant = $this->getPrixAnimal($id);
        $poids = $this->getPoidsMinAnimal($idAnimal);
        $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction,montant,date_transaction,utilisateur_id,animal_id,quantite) 
        VALUES ('vente',$montant,'$date',$id_utilisateur,$idAnimal,$quantite)";

        $sql2 = "INSERT INTO ELEVAGE_ANIMAL(nom,poids_actuel,date_achat,utilisateur_id,type_animal_id,quantite) VALUES 
        ('$nom',$poids,'$date',$id_utilisateur,$idAnimal,$quantite)";

    }
}
?>