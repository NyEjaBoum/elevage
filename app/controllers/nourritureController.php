<?php

namespace app\controllers;

use app\models\nourritureModel;
use Flight;
use PDO;

class nourritureController {
    private $db;
    private $nourritureModel;

    public function __construct() {

    }

    public function showFoodPurchaseForm() {
        $userId = $_SESSION['user'];
        $n = new nourritureModel(Flight::db());
        $foods = $n->getAllFoods($userId);
        $animals = $n->getAnimalsByUser($userId);
        Flight::render('nourriture', [
            'foods' => $foods,
            'animals' => $animals
        ]);
    }

    public function achatNourriture(){
        $idNourriture = $_POST['food_id'];
        $quantite = $_POST['quantite'];
        $n = new nourritureModel(Flight::db());
        $achat = $n->updateStockUtilisateur($_SESSION['user'],$idNourriture,$quantite);
        Flight::redirect('food?success');
    }
}
?>