<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'remotemysql.com',
    'database' => 'Hi5USsV2ss',
    'username' => 'Hi5USsV2ss',
    'password' => 'aPN9Bw5EUc',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

/*
    'database' => $_ENV['MYSQL_DB'],
    'username' => $_ENV['MYSQL_USER'],
    'password' => $_ENV['MYSQL_PASS'],
*/