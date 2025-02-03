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
            if(!isset($_POST['nom']) || !isset($_POST['poids_actuel']) || 
               !isset($_POST['type_animal_id']) || !isset($_POST['vendeur_id']) || 
               !isset($_POST['prix']) || !isset($_POST['animal_id']) || !isset($_POST['quantite'])) {
                Flight::redirect('/error?message=Donnees_manquantes');
                return;
            }
    
            $e = new AchatModel(Flight::db());
            
            $result = $e->achatAnimalTransaction(
                $_POST['nom'],
                $_POST['poids_actuel'],
                date('Y-m-d'),
                true,
                $_SESSION['user'],
                $_POST['type_animal_id'],
                $_POST['vendeur_id'],
                $_POST['animal_id'],
                $_POST['prix'],
                $_POST['quantite']
            );
    
            if($result) {
                Flight::redirect('list');
            } else {
                Flight::redirect('/error?message=Erreur_transaction');
            }
    
        } 
    }
?>