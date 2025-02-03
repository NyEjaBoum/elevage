<?php
namespace app\controllers;

use app\models\venteModel;
use Flight;

class venteController {
    private $db;

    public function __construct() {

    }

    public function venteAnimal(){
        $idAnimal = $_GET['id'];
        $date = date('Y-m-d H:i:s'); // Date actuelle
        $user = $_SESSION['user'];
        $quantite = $_GET['quantite'];
        $u = new venteModel(Flight::db());
        $vente = $u->venteAnimal($idAnimal,$user,$date,$quantite);
        //Flight::redirect("list");
    }
}
?>