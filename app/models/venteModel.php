<?php
namespace app\models;

use Flight;
use PDO;

class venteModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function venteAnimal($idAnimal,$id_utilisateur){
        // transcation
        //table animal
        $sql1 = "INSERT INTO elevage_transactionAnimal (type_transaction,montant,date_transaction,utilisateur_id,animal_id,quantite)"
    }
}
?>