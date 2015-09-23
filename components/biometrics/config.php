<?php

$config = include('config.php');
$prefix = $config['dbPref'];

$db_array = array(
	'tables' => array(
		'users'                     => $prefix . 'users',
		'users_requiring_negatives' => $prefix . 'users_requiring_negatives',
		'user_last_distance'        => $prefix . 'user_last_distance',
		'positive_data'             => $prefix . 'positive_data',
		'negative_data'             => $prefix . 'negative_data',
		'positive_dmod'             => $prefix . 'positive_dmod',
		'negative_dmod'             => $prefix . 'negative_dmod',
		'delayed_auth_attempts'     => $prefix . 'delayed_auth_attempts'
	),
	'config' => array(
		'user'     => $config['dbUser'],
		'password' => $config['dbPass'],
		'name'     => $config['dbName'],
		'host'     => $config['dbHost'],
		'port'     => 3306
	)
);

$pdo_config = "mysql:host=" . $db_array['config']['host'] . ";port=" . $db_array['config']['port'] . ";dbname=" . $db_array['config']['name'];
$db_array["pdo"] = new PDO($pdo_config, $db_array['config']['user'], $db_array['config']['password']);
