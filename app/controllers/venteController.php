<?php

namespace app\controllers;

use app\models\venteModel;
use Flight;

class venteController
{
    private $db;
    private $venteModel;

    public function __construct() {}

    
    public function planifierVente() {
        $b = new venteModel(Flight::db());
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['date_vente']) || !isset($_POST['animal_id'])) {
                Flight::redirect('/elevage/error?message=Donnees_manquantes');
                return;
            }
    
            $animalId = $_POST['animal_id'];
            $datePrevue = $_POST['date_vente'];
            $userId = $_SESSION['user'];
    
            if ($b->planifierVenteAnimal($animalId, $userId, $datePrevue)) {
                Flight::redirect('/elevage/list?success=planification_reussie');
                return;
            }
    
            Flight::redirect('/elevage/error?message=Erreur_planification');
            return;
        }
    
        // GET request - display form
        if (!isset($_GET['id'])) {
            Flight::redirect('/elevage/error?message=ID_manquant');
            return;
        }
    
        $animal = $b->getAnimalDetails($_GET['id']);
        if (!$animal) {
            Flight::redirect('/elevage/error?message=Animal_introuvable');
            return;
        }
    
        Flight::render('planifier', ['animal' => $animal]);
    }    public function venteAnimal()
    {
        $b = new venteModel(Flight::db());
        // Vérification des paramètres requis
        if (!isset($_GET['id']) || !isset($_GET['quantite'])) {
            Flight::redirect('error?message=Parametres_manquants');
            return;
        }

        $idAnimal = $_GET['id'];
        $user = $_SESSION['user'];
        $quantite = $_GET['quantite'];

        // Vérifier si l'animal est en autoVente
        $autoVente = $b->checkAutoVenteStatus($idAnimal);

        if ($autoVente === false) {
            Flight::redirect('planifier?id=' . $idAnimal);
            return;
        }

        $date = date('Y-m-d H:i:s');
        $vente = $b->venteAnimale($idAnimal, $user, $date, $quantite);

        if ($vente) {
            Flight::redirect('list?success=vente_reussie');
        } else {
            Flight::redirect('error?message=Erreur_vente');
        }
    }
}
