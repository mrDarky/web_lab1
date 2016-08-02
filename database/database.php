<?php
/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/2/16
 * Time: 7:28 PM
 */

$db_config =
[
    'ip' => 'localhost',
    'port'=> '27017'
];

$manager = new MongoDB\Driver\Manager("mongodb://".$db_config['ip'].":".$db_config['port']);

$filter = ['name' => 'Trees1'];
$query = new MongoDB\Driver\Query($filter);

$rows = $manager->executeQuery('lab1.trees', $query);

foreach ($rows as $r)
{
    print_r($r);
}

?>