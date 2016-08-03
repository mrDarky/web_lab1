<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 7:30 PM
 */

use Phalcon\Http\Response;

function api_update_tree ($app, $json_request) {

    $response = new Response();
    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $tree = [
            '_id' => new MongoDB\BSON\ObjectID,
            'title' => $json_request->title,
            'author' => $json_request->author,
            'counter' => 0
        ];
        $bulk->insert($tree);
        $app->mongo->executeBulkWrite('lab1.trees', $bulk);

        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => "OK",
                'id' => (string)$tree['_id']
            )
        );
    } catch (MongoDB\Driver\Exception\Exception $e)
    {
        $response->setStatusCode(409, "Conflict");
        $response->setJsonContent(
            array(
                'status' => "ERROR",
                'exception' => $e
            )
        );
    }

    return $response;

}