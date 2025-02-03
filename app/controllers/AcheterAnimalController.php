<?php

namespace app\controllers;

use app\models\AcheterAnimalModel;
use Flight;
use PDO;

class AcheterAnimalController {
    private $db;

    public function __construct() {
    
    }

    public function getAnimaux() {
        $e = new AcheterAnimalModel(Flight::db());
        $listings = $e->getAnimalsByUser();
        Flight::render('listeAcheterAnimal',['listings' => $listings]);
    }
}

?>