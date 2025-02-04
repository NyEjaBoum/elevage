<?php
namespace app\controllers;

use app\models\venteModel;
use Flight;

class venteController {
    private $db;

    public function __construct() {

    }

    public function venteAnimal() {
            $idAnimal = $_GET['id'];
            $date = date('Y-m-d H:i:s'); // Date actuelle
            $user = $_SESSION['user'];
            $quantite = $_GET['quantite'];
    
            // Validation des données
            if (empty($idAnimal) || empty($quantite)) {
                throw new Exception("Données manquantes pour la vente.");
            }
    
            $u = new venteModel(Flight::db());
            $vente = $u->venteAnimal($idAnimal, $user, $date, $quantite);
    
            if (!$vente) {
                Flight::redirect("list?error");
            }
            else{
            Flight::redirect("list?success");

            }
    
            // Redirection en cas de succès
    }
}
?>