<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 5:44 PM
 */
use Phalcon\Http\Response;

function api_get_human_with_id ($app, $id) {
    $response = new Response();
    try {
        $filter = [ '_id' => new MongoDB\BSON\ObjectID($id) ];
        $query = new MongoDB\Driver\Query($filter);
        $tree = $app->mongo->executeQuery("lab1.humans", $query)->toArray()[0];

        if ($tree == false) {
            $response->setJsonContent(
                array(
                    'status' => 'NOT-FOUND'
                )
            );
        } else {
            $response->setJsonContent(
                array(
                    'identifier' => (string)$tree->_id,
                    'name' => $tree->name,
                    'surname' => $tree->surname,
                    'middlename' => $tree->middlename,
                    'father' => $tree->father,
                    'mother' => $tree->mother,
                    'children' => $tree->children
                )
            );
        }

    } catch (MongoDB\Driver\Exception\Exception $e) {
        $response->setJsonContent(
            array(
                'status' => 'DATABASE-ERROR',
                'exception' => $e->getMessage()
            )
        );
    }
    return $response->send();
}