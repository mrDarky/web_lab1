<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$array_files[] = glob('api/*/*.php');
$array_files[] = glob('models/*.php');

foreach ($array_files as $files) {
    foreach ($files as $file) {
        require_once($file);
    }
}

// $file = 'log.txt';
// $current = file_get_contents($file);
// $current .= var_export(, true)."/n";
// file_put_contents($file, $current);

try {

    $di = new FactoryDefault();
    $di->set('mongo', function (){
        $mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        return $mongo;
    }, true);

    $app = new Micro();
    $app->setDI($di);

    $app->get('/authorization', function () use ($app) {
        api_get_authorization($app);
    });

    // api for trees
    $app->get('/trees', function () use ($app) {
        api_get_trees($app);
    });

    $app->get('/trees/{id}', function ($id) use ($app) {
        api_get_tree_with_id($app, $id);
    });

    $app->post('/trees', function () use ($app) {
        api_post_tree($app, json_decode($app->request->getPost('jsonRequest')));
    });

    $app->put('/trees/{id}', function ($id) use ($app) {
        api_update_tree($app, $id, json_decode($app->request->getPut('jsonRequest')));
    });

    $app->delete('/trees/{id}', function ($id) use ($app) {
        api_delete_tree($app, $id);
    });

    // api for humans
    $app->get('/trees/{treeId}/humans', function ($treeId) use ($app) {
        api_get_humans($app, $treeId);
    });

    $app->get('/humans/{id}', function ($id) use ($app) {
        api_get_human_with_id($app, $id);
    });

    $app->post('/trees/{treeId}/humans', function ($treeId) use ($app) {
        api_post_human($app, $treeId, json_decode($app->request->getPost('jsonRequest')));
    });

    $app->put('/humans/{id}', function ($id) use ($app) {
        api_update_human($app, $id, json_decode($app->request->getPut('jsonRequest')));
    });

    $app->delete('/humans/{id}', function ($id) use ($app) {
        api_delete_human($app, $id);
    });

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'Not valid query!';
    });



    $app->handle();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}