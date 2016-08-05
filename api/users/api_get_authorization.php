<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/5/16
 * Time: 4:28 PM
 */

use Phalcon\Http\Response;

function api_get_authorization($app) {

    $response = new Response();

    try {
        $newUser = new User;

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert($newUser->saveToDB());
        $app->mongo->executeBulkWrite('lab1.users', $bulk);

        $response->setStatusCode(201, "Created new user");
        $response->setJsonContent(
            array(
                'status' => "OK",
                'user_token' => $newUser->getToken()
            )
        );

    } catch (MongoDB\Driver\Exception\Exception $e)
    {
        $response->setStatusCode(409, "Conflict");
        $response->setJsonContent(
            array(
                'status' => "ERROR"
            )
        );
    }


    return $response->send();
}