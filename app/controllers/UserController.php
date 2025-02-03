<?php
namespace app\controllers;

use app\models\UserModel;
use Flight;

class UserController {
    private $db;

    public function __construct() {

    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new UserModel(Flight::db());
            $result = array();
            $result = $user->login($_POST['nom'],$_POST['mdp']);
            if ($result) {
                $_SESSION['user'] = $result[0]['id'];
                Flight::redirect('../../list');
            }
        }
    }    


    public function signin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new UserModel(Flight::db());
            $test = $user->signin($_POST['nom'],$_POST['mdp']);
            $result = $user->login($_POST['nom'],$_POST['mdp']);

            if ($result) {
                //session_start();
                $_SESSION['user'] = $result[0]['id'];
                Flight::redirect('../../list');
            }
        }
    }
}
?>