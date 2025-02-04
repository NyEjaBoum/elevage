<?php

use app\controllers\userController;
use app\controllers\typeAnimalController;
use app\controllers\AnimalController;
use app\controllers\AchatController;
use app\controllers\AcheterAnimalController;
use app\controllers\nourritureController;
use app\controllers\venteController;
use app\controllers\SoldeController;
use app\controllers\VentePlanifieeController;
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
$p = new venteController();
$so = new SoldeController();
$us = new UserController();
$li = new VentePlanifieeController();


$router->get('/',function(){
	Flight::render('Login');
});

$router->get('/index',function(){
	Flight::render('index');
});

$router->get('/dashboard',function(){
	Flight::render('TableauDeBord');
});


$router->get('/simulation',[ $f,'simulation']);


$router->get('/template1',function(){
	Flight::render('template1');
});

$router->get('/template2',function(){
	Flight::render('template2');
}); 


$router->get('/depot',function(){
	Flight::render('depot');
}); 

$router->get('/liste',function(){
	Flight::render('liste');
}); 

$router->get('/allDepot',function(){
	Flight::render('allDepot');
}); 
$router->get('/nourrir',function(){
	Flight::render('nourrirAnimal');
});

$router->get('/nourrir',function(){
	Flight::render('nourrirAnimal');
});

$router->get('/updateType',[ $t,'updateType']);

$router->get('/venteAnimal',[ $v, 'venteAnimal']);

$router->get('/food', [$f, 'showFoodPurchaseForm']);

$router ->get('/admin',[ $t,'getAllType']);

$router->get('/admin2',[ $so, 'showDepot' ]);

$router ->get('/list',[ $l,'listAnimaux']);

$router ->get('/listeVente',[ $li,'afficherVentesPlanifiees']);

$router->post('/achat', [$ac, 'achatAnimal']);

$router->get('/listeAnimal',[ $a,'getAnimaux']);



$router->post('/login',[ $us, 'login' ]);

$router->get('/validate',[ $so, 'valideDepot' ]);

$router->post('/achatNourriture',[ $f, 'achatNourriture' ]);

$router->post('/insertDepot',[ $so , 'insertDepot' ]);

$router->post('/signin',[ $us, 'signin' ]);

$router->get('/AffichageAchat',[ $us, 'AffichageAchate' ]);

$router->get('/planifier', [$p, 'planifierVente']);
$router->post('/planifier', [$p, 'planifierVente']);

$router->get('/insertAchat',[ $AchatController, 'AchatAnimaux' ]);
//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


