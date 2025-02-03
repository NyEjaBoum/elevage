<?php

use app\controllers\userController;
use app\controllers\typeAnimalController;
use app\controllers\AnimalController;
use app\controllers\AchatController;
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



$router ->get('/admin',[ $t,'getAllType']);

$router ->get('/list',[ $l,'listAnimaux']);

$router->post('/login',[ $userController, 'login' ]);

$router->post('/signin',[ $userController, 'signin' ]);


$router->get('/AffichageAchat',[ $userController, 'AffichageAchate' ]);

$router->get('/insertAchat',[ $AchatController, 'AchatAnimaux' ]);
//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


