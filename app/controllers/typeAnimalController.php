<?php
namespace app\controllers;

use app\models\typeAnimalModel;
use Flight;

class typeAnimalController {
    private $db;

    public function __construct() {

    }

    public function getAllType(){
        $t = new typeAnimalModel(Flight::db());
        $type = $t->getAllType();
        Flight::render('admin',['type' => $type]);
    }

}
?>