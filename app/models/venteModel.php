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

    public function venteAnimal($idAnimal,$id_utilisateur,$date,$quantite){
        // transcation
        //table animal
        $montant = $this->getPrixAnimal($id);
        $poids = $this->getPoidsMinAnimal($idAnimal);
        $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction,montant,date_transaction,utilisateur_id,animal_id,quantite) 
        VALUES ('vente',$montant,'$date',$id_utilisateur,$idAnimal,$quantite)";

        $sql2 = "INSERT INTO ELEVAGE_ANIMAL(image,nom,poids_actuel,date_achat,utilisateur_id,type_animal_id,quantite) VALUES 
        ('$image','$nom',)";
    }
}
?>