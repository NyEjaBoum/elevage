<?php

namespace app\controllers;

use app\models\nourritureModel;
use app\models\venteModel;
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
        $foods = $n->getAllFoods($userId);
        $animals = $n->getAnimalsByUser($userId);
        Flight::render('nourriture', [
            'foods' => $foods,
            'animals' => $animals
        ]);
    }

    public function pseudoNourrir() {
        $userId = $_SESSION['user'];
        $n = new nourritureModel(Flight::db());
        $foods = $n->getAllFoods($userId);
        $animals = $n->getAnimalById($userId);
        Flight::render('nourriture', [
            'foods' => $foods,
            'animals' => $animals
        ]);
    }

    public function achatNourriture(){
        $idNourriture = $_POST['food_id'];
        $quantite = $_POST['quantite'];
        $n = new nourritureModel(Flight::db());
        $achat = $n->updateStockUtilisateur($_SESSION['user'],$idNourriture,$quantite);
        Flight::redirect('food?success');
    }

    public function simulation() {
        $date = $_GET['date']; // Utiliser POST au lieu de GET pour la sécurité
        $n = new nourritureModel(Flight::db());
    
        $animaux = $n->getAnimalsByUser($_SESSION['user']);
        $resultats = [];
    
        foreach ($animaux as $animal) {
            $resultatAnimal = $n->simulerAnimal($_SESSION['user'], $animal->id, $date);
            $resultatAnimal['nom'] = $animal->nom; // Ajouter le nom de l'animal
            $resultats[] = $resultatAnimal;
        }
    
        // Afficher les résultats dans la vue
        Flight::render('TableauDeBord', [
            'resultats' => $resultats,
            'date_simulation' => $date
        ]);
    }
}
?>