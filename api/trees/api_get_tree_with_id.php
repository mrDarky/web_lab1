<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 5:44 PM
 */
use Phalcon\Http\Response;

function api_get_tree_with_id ($app, $id) {
    $response = new Response();
    try {
        $filter = [ '_id' => new MongoDB\BSON\ObjectID($id) ];
        $query = new MongoDB\Driver\Query($filter);
        $tree = $app->mongo->executeQuery("lab1.trees", $query)->toArray()[0];

        if ($tree == false) {
            $response->setJsonContent(
                array(
                    'status' => 'NOT-FOUND'
                )
            );
        } else {
            if (!isset($tree->owner)) {
//                $bulk = new MongoDB\Driver\BulkWrite;
//                $owner = [
//                    'owner' => $user_token['_id']
//                ];
//                $bulk = update($tree['_id'], set($owner));
                $response->setJsonContent(
                    array(
                        'identifier' => (string)$tree->_id,
                        'title' => $tree->title,
                        'author' => $tree->author,
                        'counter' => $tree->counter
                    )
                );
            } else {
                $response->setJsonContent(
                    array(
                        'enable' => 'NO'
                    )
                );
            }
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