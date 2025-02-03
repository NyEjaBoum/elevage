<?php

use app\controllers\userController;
use app\controllers\typeAnimalController;
use app\controllers\AnimalController;
<<<<<<< HEAD
use app\controllers\AchatController;
=======
use app\controllers\nourritureController;

>>>>>>> 5cdd76d316849f22eb03b93cc14e1cbc504b6bee
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
<<<<<<< HEAD
$AchatController = new AchatController();
=======
$f = new nourritureController();

>>>>>>> 5cdd76d316849f22eb03b93cc14e1cbc504b6bee

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

$router ->get('/updateType',[ $t,'updateType']);



$router->get('/food', [$f, 'showFoodPurchaseForm']);

$router ->get('/admin',[ $t,'getAllType']);

$router ->get('/list',[ $l,'listAnimaux']);

$router->post('/login',[ $userController, 'login' ]);

$router->post('/signin',[ $userController, 'signin' ]);


$router->get('/AffichageAchat',[ $userController, 'AffichageAchate' ]);

$router->get('/insertAchat',[ $AchatController, 'AchatAnimaux' ]);
//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


