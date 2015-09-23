<?php
	$dbHost = $_POST["dbHost"];
	$dbUser = $_POST["dbUser"];
	$dbPass = $_POST["dbPass"];
	$dbName = $_POST["dbName"];

	mysql_connect($dbHost, $dbUser, $dbPass) or die("error");
	mysql_select_db($dbName) or die("error");

	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8';");

	echo "success";