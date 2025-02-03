<?php

namespace app\controllers;

use app\models\ElevageAnimalModel;
use Flight;
use PDO;

class AnimalController {
    private $db;

    public function __construct() {
    
    }

    public function listAnimaux() {
        $e = new ElevageAnimalModel(Flight::db());
        $listings = $e->getAnimauxByUtilisateur($_SESSION['user']);
        Flight::render('liste',['listings' => $listings]);
    }
}

?>