<?php

namespace app\controllers;

use app\models\AchatModel;
use Flight;
use PDO;

class AchatController {
    private $db;
    private $achatModel;

    public function __construct() {

    }

    public function achatAnimal() {
            $e = new AchatModel(Flight::db());
            $newAnimalId = $e->insertAnimal(
                $_POST['nom'],
                $_POST['poids_actuel'],
                date('Y-m-d'),
                true,
                $_SESSION['user'],
                $_POST['type_animal_id']
            );

            if ($newAnimalId) {
                Flight::redirect('/list');
            } else {
                Flight::redirect('/error?message=Erreur_insertion');
            }
    }
}
?>