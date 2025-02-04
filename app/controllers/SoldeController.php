<?php

namespace app\controllers;

use app\models\SoldeModel;
use Flight;
use PDO;

class SoldeController {
    private $db;

    public function __construct() {
      
    }
    
    public function valideDepot(){
        $id = $_GET['id'];
        $userid = $_GET['iduser'];
        $u = new SoldeModel(Flight::db());
        $valide = $u->valideDepot($id,$userid);
        Flight::redirect('/admin');
    }

    public function getInfoUser(){
        $u = new userModel(Flight::db());
        $userId = $_SESSION['user'];
        $info = $u->getInfoUser($userId); 
        $data = ['info' => $info];
        Flight::render('accueil',$data);
    }

    public function getSolde(){
        $u = new userModel(Flight::db());
        $userId = $_SESSION['user'];
        $solde = $u->getSolde($userId); 
        $data = ['solde' => $solde];
        Flight::render('solde',$data);
    }

    public function showDepot(){
        $u = new SoldeModel(Flight::db());
        $depots = $u->showDepot(); 
        $data = ['depots' => $depots];
        Flight::render('allDepot',$data);
    }

    public function insertDepot(){
        $userId = $_SESSION['user'];
        $valeur = $_POST['montant'];
        
        // Réduction de 10 % sur le montant
        
        $u = new SoldeModel(Flight::db());
        // Insertion avec le montant réduit
        $insert = $u->insertDepot($userId, $valeur);
        
        // Redirection avec le message de succès
        Flight::redirect('depot?depot=success');
    }


}
?>