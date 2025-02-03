<?php

use app\controllers\userController;
use app\controllers\HabitationController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */


$userController = new userController();
$hab = new HabitationController();


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

$router->get('/admin',function(){
	Flight::render('admin');
});

//$router->get('/list',[ $hab, 'list' ]);

//$router->get('/details',[ $hab, 'getById' ]);
//
//

$router->get('/deleteHabit',[ $hab, 'delete' ]);

$router->post('/addHabit',[ $hab, 'ajoutHabitation' ]);

$router->post('/modifHabit',[ $hab, 'modifierHabitation' ]);

$router->post('/login',[ $userController, 'login' ]);

$router->post('/signin',[ $userController, 'signin' ]);

$router->post('/reservation',[ $hab, 'reserverHabitation' ]);



$router->get('/details', function() use ($hab) {
    $hab->getById('details');
});


$router->get('/ajout', function() use ($hab) {
    $hab->getAllTypeForPage('ajoutHabit');
});

$router->get('/modif', function() use ($hab) {
    $hab->forModifPage('modifHabit');
});

//$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);


