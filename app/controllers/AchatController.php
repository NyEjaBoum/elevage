<?php

namespace app\controllers;

use app\models\AchatModel;
use Flight;
use PDO;

class AchatController {
    private $db;

    public function __construct() {
    
    }

    public function AchatAnimaux() {
        $id = $_GET['id'];
        $db2 = new AchatModel(Flight::db());
        $success = $db2->LesAchat($id);
        if ($success) {
            Flight::render('AffichageAchat',["message" => "Donnée copiée avec succès !"]);
        } 
    }
}

?>