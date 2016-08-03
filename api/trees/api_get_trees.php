<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 5:33 PM
 */
use Phalcon\Http\Response;

function api_get_trees ($app) {
    $response = new Response();
    try {
        $query = new MongoDB\Driver\Query([]);
        $trees = $app->mongo->executeQuery("lab1.trees", $query);

        if ($trees == false) {
            $response->setJsonContent(
                array(
                    'status' => 'NOT-FOUND'
                )
            );
        } else {
            $data = array();
            foreach ($trees as $tree) {
                $data[] = array(
                    'id' => (string)$tree->_id,
                    'title' => $tree->title,
                    'author' => $tree->author,
                    'counter' => $tree->counter
                );
            }
            $response->setStatusCode(201, "OK");
            $response->setJsonContent($data);
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        $response->setStatusCode(409, "Conflict");
        $response->setJsonContent(
            array(
                'status' => 'ERROR',
                'exception' => $e->getMessage()
            )
        );
    }
    return $response;
}
