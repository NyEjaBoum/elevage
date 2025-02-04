<?php

use app\controllers\userController;
use app\controllers\typeAnimalController;
use app\controllers\AnimalController;
use app\controllers\AchatController;
use app\controllers\AcheterAnimalController;
use app\controllers\nourritureController;
use app\controllers\venteController;
use app\controllers\SoldeController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$AnimalController = new AnimalController();
$userController = new userController();
$t = new typeAnimalController();
$l = new AnimalController();
$AchatController = new AchatController();
$a = new AcheterAnimalController();
$f = new nourritureController();
$ac = new AchatController();
$v = new venteController();
$SoldeController = new SoldeController();
$router->get('/',function(){
	Flight::render('Login');
});

$router->get('/index',function(){
	Flight::render('index');
});

$router->get('/template1',function(){
	Flight::render('template1');
});

$router->get('/template2',function(){
	Flight::render('template2');
}); 

<<<<<<< Updated upstream
$router->get('/depot',function(){
	Flight::render('depot');
}); 

$router->get('/liste',function(){
	Flight::render('liste');
}); 

$router->get('/allDepot',function(){
	Flight::render('allDepot');
}); 
=======
$router->get('/nourrir',function(){
	Flight::render('nourrirAnimal');
});
>>>>>>> Stashed changes

$router->get('/updateType',[ $t,'updateType']);

$router->get('/venteAnimal',[ $v, 'venteAnimal']);

$router->get('/food', [$f, 'showFoodPurchaseForm']);

$router ->get('/admin',[ $t,'getAllType']);

$router->get('/admin2',[ $SoldeController, 'showDepot' ]);

$router ->get('/list',[ $l,'listAnimaux']);

$router->post('/achat', [$ac, 'achatAnimal']);

$router->get('/listeAnimal',[ $a,'getAnimaux']);



$router->post('/login',[ $userController, 'login' ]);

$router->get('/validate',[ $SoldeController, 'valideDepot' ]);

$router->post('/achatNourriture',[ $f, 'achatNourriture' ]);

$router->post('/insertDepot',[ $SoldeController , 'insertDepot' ]);

$router->post('/signin',[ $userController, 'signin' ]);

$router->get('/AffichageAchat',[ $userController, 'AffichageAchate' ]);

$router->get('/insertAchat',[ $AchatController, 'AchatAnimaux' ]);
//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


