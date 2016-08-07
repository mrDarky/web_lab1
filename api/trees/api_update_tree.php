<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 7:30 PM
 */

use Phalcon\Http\Response;

function api_update_tree ($app, $id, $json_request) {

    $response = new Response();
    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $data = array();

        if (isset($json_request->title))
        {
            $data['title'] = $json_request->title;
        }
        if (isset($json_request->author))
        {
            $data['author'] = $json_request->author;
        }

        $bulk->update(['_id' => new MongoDB\BSON\ObjectID($id)], ['$set' => $data]);
        $app->mongo->executeBulkWrite('lab1.trees', $bulk);

        $response->setStatusCode(201, "Update");
        $response->setJsonContent(
            array(
                'status' => "OK"
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