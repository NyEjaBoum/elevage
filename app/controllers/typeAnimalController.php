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

    public function createType(){
        
    }

    public function LesAchat($id){
    $db = new typeAnimalModel(Flight::db());

    // Récupérer les données depuis `propos`
    $propos = $db->query("SELECT * FROM elevage_animal")->fetchAll(PDO::FETCH_ASSOC);

    // Insérer les données dans `propos2.0`
    foreach ($propos as $row) {
        $query = "INSERT INTO `elevage_animal_for_Achat` (id, image, nom, age) VALUES (:id, :nom, :age)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':id'   => $row['id'],
            ':nom'  => $row['nom'],
            ':age'  => $row['age']
        ]);
    }

    echo "Les données ont été copiées avec succès !";
}



}
?>