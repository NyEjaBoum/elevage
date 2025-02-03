<?php

namespace app\controllers;

use app\models\ElevageAnimalModel;
use Flight;
use PDO;

class AnimalController {
    private $db;
    private $elevageAnimalModel;

    public function __construct($db) {
        $this->db = $db;
        $this->elevageAnimalModel = new ElevageAnimalModel($this->db);
    }

    public function listAnimaux() {
        $animaux = $this->elevageAnimalModel->getAnimauxByUtilisateur($_SESSION['user']);
        Flight::render('liste',['animaux' => $animaux]);
    }
}

?>