<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 8:18 PM
 */

use Phalcon\Http\Response;

function api_delete_human ($app, $id) {

    $response = new Response();
    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $filter = [
            '_id' => new MongoDB\BSON\ObjectID($id),
            'mother' => $id,
            'father' => $id
        ];

        $bulk->delete($filter);
        $app->mongo->executeBulkWrite('lab1.humans', $bulk);

        $response->setStatusCode(201, "Delete");
        $response->setJsonContent(
            array(
                'status' => "Deleted"
            )
        );
    } catch (MongoDB\Driver\Exception\Exception $e)
    {
        $response->setStatusCode(409, "Conflict");
        $response->setJsonContent(
            array(
                'status' => "ERROR",
                'exception' => $e->getMessage()
            )
        );
    }

    return $response->send();
}