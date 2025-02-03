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
        $foods = $n->getFoodsByUser($userId);
        $animals = $n->getAnimalsByUser($userId);
        // $purchaseHistory = $n->getFoodPurchaseHistoryByUser($userId);

        // $remainingCapital = isset($_SESSION['farmManager']) ? $_SESSION['farmManager']->getRemainingCapital() : 0;

        Flight::render('nourriture', [
            'foods' => $foods,
            'animals' => $animals,
            // 'purchaseHistory' => $purchaseHistory,
            // 'remainingCapital' => $remainingCapital
        ]);
    }
}
?>