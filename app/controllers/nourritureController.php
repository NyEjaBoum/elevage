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
        $date = $_GET['date'];
        $userId = $_SESSION['user'];
        $n = new nourritureModel(Flight::db());
        $v = new venteModel(Flight::db());
        
        $animaux = $n->getAnimalsByUser($userId);
        $resultats = [];
    
        // Trier les animaux par priorité
        usort($animaux, function($a, $b) use ($n, $v) {
            $poidsMinA = $v->getPoidsMinAnimal($a->type_animal_id);
            $poidsMinB = $v->getPoidsMinAnimal($b->type_animal_id);
            
            $distanceA = $poidsMinA - $a->poids_actuel;
            $distanceB = $poidsMinB - $b->poids_actuel;
            
            return $distanceA <=> $distanceB;
        });
    
        foreach ($animaux as $animal) {
            $resultats[$animal->id] = [
                'nom' => $animal->nom,
                'type_animal_id' => $animal->type_animal_id,
                'simulations' => []
            ];
            
            $nourritures = $n->getAllNourritureUserForAnimal($userId, $animal->type_animal_id);
            if (empty($nourritures)) {
                continue;
            }
            
            $nourriture = $nourritures[0];
            $stockInitial = $n->getQuantiteStock($userId, $nourriture['nourriture_id']);
            $poidsActuel = $v->getPoidsActuel($animal->id, $userId);
            
            $dateActuelle = new \DateTime();
            $dateSimulation = new \DateTime($date);
            $interval = $dateActuelle->diff($dateSimulation);
            $joursSimulation = $interval->days;
    
            for ($jour = 0; $jour < $joursSimulation; $jour++) {
                $dateJour = date('Y-m-d', strtotime("+$jour days"));
                
                // Vérifier le stock disponible
                $stockDisponible = $n->getQuantiteStock($userId, $nourriture['nourriture_id']);
                
                if ($stockDisponible >= 1) {
                    $poidsInitial = $v->getPoidsActuel($animal->id, $userId);
                    $n->nourrir($userId, $nourriture['nourriture_id'], $animal->id, 1);
                    $nouveauPoids = $v->getPoidsActuel($animal->id, $userId);
                    
                    $resultats[$animal->id]['simulations'][] = [
                        'date' => $dateJour,
                        'poids_initial' => $poidsInitial,
                        'poids_final' => $nouveauPoids,
                        'nourriture_utilisee' => 1,
                        'stock_restant' => $stockDisponible - 1,
                        'stock_initial' => $stockInitial
                    ];
                } else {
                    $poidsActuel = $v->getPoidsActuel($animal->id, $userId);
                    $resultats[$animal->id]['simulations'][] = [
                        'date' => $dateJour,
                        'poids_initial' => $poidsActuel,
                        'poids_final' => $poidsActuel,
                        'nourriture_utilisee' => 0,
                        'stock_restant' => $stockDisponible,
                        'stock_initial' => $stockInitial
                    ];
                }
            }
        }
    
        Flight::render('TableauDeBord', [
            'resultats' => $resultats,
            'date_simulation' => $date
        ]);
    }

}
?>