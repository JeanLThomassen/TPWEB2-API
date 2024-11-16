<?php
    
    require_once 'libs/router.php';

    require_once 'app/controllers/cap.api.controller.php';
    $router = new Router();

    #                  endpoint                      verbo      controller            metodo
    $router->addRoute('capitulos'      ,            'GET',     'CapApiController',   'getAll');
    $router->addRoute('capitulos/:id'  ,            'GET',     'CapApiController',   'get');
    $router->addRoute('capitulos'  ,                'POST',    'CapApiController',   'add');
    $router->addRoute('capitulos/:id'  ,            'PUT',     'CapApiController',   'update');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
