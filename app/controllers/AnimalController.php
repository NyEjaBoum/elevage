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
    public function listAnimaux($utilisateur_id) {
        // Récupérer les animaux de l'utilisateur
        $animaux = $this->elevageAnimalModel->getAnimauxByUtilisateur($utilisateur_id);

        // Renvoyer les données au format JSON (ou à une vue)
        Flight::json([
            'status' => 'success',
            'data' => $animaux
        ]);
    }
}

?>