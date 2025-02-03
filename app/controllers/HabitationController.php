<?php
namespace app\controllers;

use app\models\HabitationModel;
use Flight;

class HabitationController {
    private $db;

    public function __construct() {

    }

    // Lister toutes les habitations
    public function list() {
        $habitationModel = new HabitationModel(Flight::db());
        $habitations = $habitationModel->getAll();
        Flight::render('liste', ['habitations' => $habitations]);
    }

    //Liste des animaux achetere
    public function listAcheter() {
        $habitationModel = new HabitationModel(Flight::db());
        $listAcheter = $habitationModel->getlistAcheter();
        Flight::render('listeAheter', ['listAcheter' => $listAcheter]);
    }

    public function list2() {
        $habitationModel = new HabitationModel(Flight::db());
        $habitations = $habitationModel->getAll();
        Flight::render('listeHabitation', ['habitations' => $habitations]);
    }

    // Modifier une habitation
    public function edit($id) {
        $habitationModel = new HabitationModel(Flight::db());
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $habitationModel->update($id, $_POST);
            Flight::redirect('/list_habitations');
        } else {
            $habitation = $habitationModel->getById($id);
            Flight::render('edit_habitation', ['habitation' => $habitation]);
        }
    }

    // Supprimer une habitation
    public function delete() {
        $id = $_GET['id'];
        $habitationModel = new HabitationModel(Flight::db());
        $habitationModel->delete($id);
        Flight::redirect('../../admin');
    }

    public function getById($page) {
        $id = $_GET['id'];
        $habitationModel = new HabitationModel(Flight::db());
        $det = $habitationModel->getById($id);
        $images = $habitationModel->getAllImagesById($id);
        Flight::render($page, [
            'detai' => $det,
            'images' => $images
        ]);
    }

    public function getAllType(){
        $habitationModel = new HabitationModel(Flight::db());
        $type = $habitationModel->getAllType();
        Flight::render('ajoutHabit', ['type' => $type]);
    }

    public function getAllTypeForPage($page) {
        $habitationModel = new HabitationModel(Flight::db());
        $type = $habitationModel->getAllType();
        Flight::render($page, ['type' => $type]);
    }
    
    public function forModifPage($page) {
        $habitationModel = new HabitationModel(Flight::db());
        $type = $habitationModel->getAllType();
        $id = $_GET['id'];
        $det = $id ? $habitationModel->getById($id) : null;
        $images = $id ? $habitationModel->getAllImagesById($id) : [];
        Flight::render($page, [
            'type' => $type,
            'details' => $det,
            'images' => $images
        ]);
    }
    

    public function ajoutHabitation() {
        $type = $_POST['type'];
        $quartier = $_POST['quartier'];
        $chambres = $_POST['chambres'];
        $loyer = $_POST['loyer'];
        $desc = $_POST['description'];
    
        $data = [
            'type' => $type,
            'chambres' => $chambres,
            'loyer' => $loyer,
            'quartier' => $quartier,
            'description' => $desc
        ];
    
        $images = [];
        if (isset($_FILES['image'])) {
            foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
                $images[] = [
                    'name' => $_FILES['image']['name'][$key],
                    'tmp_name' => $tmp_name
                ];
            }
        }
    
        $habitationModel = new HabitationModel(Flight::db());
        $result = $habitationModel->ajouterHabitation($data, $images);
    
        if ($result) {
            Flight::redirect('../../admin');
        } else {
            Flight::halt(500, "Erreur lors de l'ajout de l'habitation.");
        }
    }
    
  ////logique modification  
public function modifierHabitation() {
    $id = $_GET['id'];
    $type = $_POST['type'];
    $quartier = $_POST['quartier'];
    $chambres = $_POST['chambres'];
    $loyer = $_POST['loyer'];
    $desc = $_POST['description'];
    $idImage = $_POST['idImage'];

    $data = [
        'type' => $type,
        'chambres' => $chambres,
        'loyer' => $loyer,
        'quartier' => $quartier,
        'description' => $desc
    ];

    $images = [];
    if (isset($_FILES['image'])) {
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            $images[] = [
                'name' => $_FILES['image']['name'][$key],
                'tmp_name' => $tmp_name
            ];
        }
    }

    $habitationModel = new HabitationModel(Flight::db());
    $result = $habitationModel->modifierHabitation($id,$data, $images,$idImage);

    if ($result) {
        //Flight::redirect('../../admin');
    } else {
        Flight::halt(500, "Erreur lors de l'ajout de l'habitation.");
    }
}

    ////reservation 
    public function reserverHabitation(){
        $habitationModel = new HabitationModel(Flight::db());
        $isReserver = $habitationModel->isReserver($_GET['id'],$_POST['date1'],$_POST['date2']);
        if(!$isReserver){
            $reservation = $habitationModel->reservationHabitation($_GET['id'],$_SESSION['user'],$_POST['date1'],$_POST['date2']);
            if($reservation){
                Flight::redirect('../../details?success&&id='.$_GET['id']);
            }
        }
        else{
            Flight::redirect('../../details?fail&&id='.$_GET['id']);
        }
    }
}
?>