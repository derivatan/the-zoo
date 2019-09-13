<?php

/**
 * @var $router Laravel\Lumen\Routing\Router
 */

// Client
$router->get('/', 'ClientController@index');

// Server
$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->get('test', 'ServerController@test');

    $router->get('question', 'QuestionController@getQuestion');
    $router->post('question', 'QuestionController@saveQuestion');

});
