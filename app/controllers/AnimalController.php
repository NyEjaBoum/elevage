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

    /**
     * Liste les animaux d'un utilisateur.
     *
     * @param int $utilisateur_id L'ID de l'utilisateur.
     */
    public function listAnimaux() {
        $animaux = $this->elevageAnimalModel->getAnimauxByUtilisateur($_SESSION['user']);
        Flight::render('liste',['animaux' => $animaux]);
    }
}

?>