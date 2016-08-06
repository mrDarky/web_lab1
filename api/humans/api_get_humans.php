<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/3/16
 * Time: 5:33 PM
 */
use Phalcon\Http\Response;

function api_get_humans ($app, $treeId) {
    $response = new Response();
    try {
        $query = new MongoDB\Driver\Query([
            'treeId' => $treeId
        ]);
        $humans = $app->mongo->executeQuery("lab1.humans", $query);

        if ($humans == false) {
            $response->setJsonContent(
                array(
                    'status' => 'ERROR'
                )
            );
        } else {
            $data = array();
            foreach ($humans as $human) {
//                if ($human->name == null){
//                    $human->name = null;
//                }
//                if ($human->surname == null){
//                    $human->surname = null;
//                }
//                if ($human->middlename == null){
//                    $human->middlename = null;
//                }
                if ($human->father == null){
                    $human->father = null;
                }
                if ($human->mother == null){
                    $human->mother = null;
                }
                if ($human->children == null){
                    $human->children = null;
                }
                $data[] = array(
                    'identifier' => (string)$human->_id,
                    'name' => $human->name,
                    'surname' => $human->surname,
                    'middlename' => $human->middlename,
                    'gender' => $human->gender,
                    'father' => $human->father,
                    'mother' => $human->mother,
                    'children' => $human->children
                );
            }

            $response->setStatusCode(201, "OK");
            $response->setContentType('application/json', 'UTF-8');
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

    return $response->send();
}
