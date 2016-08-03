<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/2/16
 * Time: 7:28 PM
 */

require_once 'Database.class.php';

$db_config =
[
    'ip' => 'localhost',
    'port'=> '27017'
];


$database = new Database($db_config['ip'], $db_config['port']);

$some = Database::manager;

$filter = ['name' => 'Trees1'];
$query = new MongoDB\Driver\Query($filter);

$rows = $database->manager;
    //->executeQuery('lab1.trees', $query);

foreach ($rows as $r)
{
    print_r($r);
}

?>