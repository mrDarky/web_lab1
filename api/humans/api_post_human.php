<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 6:33 PM
 */

use Phalcon\Http\Response;

function api_post_human ($app, $treeId, $json_request) {

    $response = new Response();

    try {
        $filter = [ '_id' => new MongoDB\BSON\ObjectID($treeId) ];
        $query = new MongoDB\Driver\Query($filter);
        $tree = $app->mongo->executeQuery("lab1.trees", $query)->toArray()[0];

        if ($tree == false) {
            $response->setJsonContent(
                array(
                    'status' => 'TREE NOT-FOUND'
                )
            );
        } else {
            $bulk = new MongoDB\Driver\BulkWrite;
            $human = [
                '_id' => new MongoDB\BSON\ObjectID,
                'name' => $json_request->name,
                'surname' => $json_request->surname,
                'middlename' => $json_request->middlename,
                'gender' => 'male',
                'father' => null,
                'mother' => null,
                'children' => null,
                'treeId' => $treeId
            ];
            $bulk->insert($human);
            $app->mongo->executeBulkWrite('lab1.humans', $bulk);

            $response->setStatusCode(201, "Created");
            $response->setJsonContent(
                array(
                    'identifier' => (string)$human['_id'],
                    'name' => $human['name'],
                    'surname' => $human['surname'],
                    'middlename' => $human['middlename']
                )
            );
        }
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