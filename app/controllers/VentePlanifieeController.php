<?php
namespace app\controllers;

use app\models\VentePlanifieeModel;
use Flight;

class VentePlanifieeController {
    private $db;
    private $model;

    public function __construct() {

    }

    public function afficherVentesPlanifiees() {
        $a = new VentePlanifieeModel(Flight::db());
        $userId = $_SESSION['user'];
        $ventes = $a->getVentesPlanifiees($userId);
        Flight::render('listeVentePlanifier', ['ventes' => $ventes]);
    }
}

?>