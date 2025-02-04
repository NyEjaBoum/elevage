<?php

namespace app\models;

use PDO;
use PDOException;

class SoldeModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function achatNourriture($userId,$idNourriture){
        $sql = "INSERT INTO elevage_stockUtilisateur (idNourriture,utilisateur_id) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idNourriture,$userId]);
    }
   ////////////////////////////////////////////////////////
    public function insertDepot($userId,$montant){
        $sql = "INSERT INTO elevage_depots(idUser,valeur)VALUES($userId,$montant)";
        $this->db->query($sql);

        $depotAccepterTotal = $this->getDepotUser($userId);
        $newSolde = $depotAccepterTotal;
        
        $sql2 = "UPDATE elevage_utilisateur SET Capital = $newSolde WHERE ID = $userId";
        $this->db->query($sql2);
    }
   ///////////////////////////////////////////////////////
    public function showDepot(){
        $sql = "SELECT * FROM elevage_depots";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getDepotUser($userId){
        $sql = "SELECT SUM(VALEUR) AS DEPOTS FROM elevage_depots WHERE IDUSER = $userId";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['DEPOTS'];
    }



    public function getSolde($userId) {
        $sql = "SELECT SOLDE FROM USERS WHERE ID = $userId";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['SOLDE'];
    }

    
}
?>