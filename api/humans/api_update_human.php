<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 7:30 PM
 */

use Phalcon\Http\Response;

function api_update_human ($app, $id, $json_request) {

    $response = new Response();
    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $data = array();

        if (isset($json_request->name))
        {
            $data['name'] = $json_request->name;
        }
        if (isset($json_request->surname)) {
            $data['surname'] = $json_request->surname;
        }
        if (isset($json_request->middlename))
        {
            $data['middlename'] = $json_request->middlename;
        }
        if (isset($json_request->father))
        {
            $data['father'] = $json_request->father;
        }
        if (isset($json_request->mother))
        {
            $data['mother'] = $json_request->mother;
        }
        if (isset($json_request->gender))
        {
            $data['gender'] = $json_request->gender;
        }
        $bulk->update(['_id' => new MongoDB\BSON\ObjectID($id)], ['$set' => $data]);
        $app->mongo->executeBulkWrite('lab1.humans', $bulk);

        $response->setStatusCode(201, "Update");
        $data['status'] = "OK";
        $response->setJsonContent($data);
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