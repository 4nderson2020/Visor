<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// $ph_serv = '172.22.0.17'; 
// $pass_serv = '$4dm1n$2oi8&';

// //DESARROLLO
 $ph_serv = '172.22.0.80'; 
$pass_serv = '$4dm1n$';

$pg_db = 'bdidemi';
$db['default'] = array(
        'dsn'   => 'pgsql:host='.$ph_serv.';port=5432;dbname='.$pg_db,
        'hostname' => $ph_serv,
        'port'   => 5432, 
        'username' => 'idemi',
        'password' => $pass_serv,
        'database' => $pg_db,
        'dbdriver' => 'pdo',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array()
);


