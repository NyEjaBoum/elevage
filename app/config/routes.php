<?php

use app\controllers\userController;
use app\controllers\typeAnimalController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */


$userController = new userController();
$t = new typeAnimalController();

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

$router->get('/list',function(){
	Flight::render('liste');
});

$router ->get('/admin',[ $t,'getAllType']);

$router->post('/login',[ $userController, 'login' ]);

$router->post('/signin',[ $userController, 'signin' ]);


//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


