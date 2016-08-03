<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;


$files = glob('api/trees/*.php');

foreach ($files as $file) {
    require_once($file);
}

try {
    $loader = new Loader();
    $loader->registerDirs(
        array(
            __DIR__ . '/models/'
        )
    ) -> register();


    $di = new FactoryDefault();
    $di->set('mongo', function (){
        $mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        return $mongo;
    }, true);

    $app = new Micro();
    $app->setDI($di);

    $app->get('/trees', function () use ($app) {
        return api_get_trees($app);
    });

    $app->get('/trees/{id}', function ($id) use ($app) {
        return api_get_tree_with_id($app, $id);
    });

    $app->post('/trees', function () use ($app) {
        return api_post_tree($app, $app->request->getJsonRawBody());
    });

    $app->put('/trees/{id}', function ($id) use ($app) {
        return api_update_tree($app, $id, $app->request->getJsonRawBody());
    });

    $app->delete('/trees/{id}', function ($id) use ($app) {
        return api_delete_tree($app, $id);
    });

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'Not valid query!';
    });

    $app->handle();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}