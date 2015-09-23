<?php
	$dbHost = $_POST["dbHost"];
	$dbUser = $_POST["dbUser"];
	$dbPass = $_POST["dbPass"];
	$dbName = $_POST["dbName"];

	$adminLogin = $_POST["adminLogin"];
	$adminEmail = $_POST["adminEmail"];
	$adminPass = md5($_POST["adminPass"]);
	$adminControl = $_POST["adminControl"];

	$siteName = $_POST["siteName"];
	$dbPref = $_POST["dbPref"];

	file_put_contents('config.php', '<?php
	return array(
		"dbHost" => "'.$dbHost.'",
		"dbUser" => "'.$dbUser.'",
		"dbPass" => "'.$dbPass.'",
		"dbName" => "'.$dbName.'",
		"dbPref" => "'.$dbPref.'"
	);');

	mysql_connect($dbHost, $dbUser, $dbPass);
	mysql_select_db($dbName);

	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8';");

	$sql = "CREATE TABLE `".$dbPref."config` (
		`key` varchar(30) NOT NULL,
		`value` varchar(30) NOT NULL
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`role` int NOT NULL,
		`status` varchar(30) NOT NULL,
		`login` varchar(50) NOT NULL,
		`email` varchar(50) NOT NULL,
		`pass` varchar(50) NOT NULL,
		`token` varchar(50) NOT NULL,
		`secret_code` mediumtext NOT NULL,
		`profile_pic` mediumtext NOT NULL,
		`first_name` varchar(50) NOT NULL,
		`last_name` varchar(50) NOT NULL,
		`about` mediumtext NOT NULL,
		PRIMARY KEY (`id`) 
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."groups` (
		`id` int NOT NULL AUTO_INCREMENT,
		`privacy` int NOT NULL,
		`status` varchar(30) NOT NULL,
		`author` int NOT NULL,
		`title` varchar(50) NOT NULL,
		`descr` mediumtext NOT NULL,
		`group_pic` mediumtext NOT NULL,
		PRIMARY KEY (`id`) 
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."categories` (
		`id` int NOT NULL AUTO_INCREMENT,
		`status` varchar(30) NOT NULL,
		`title` varchar(50) NOT NULL,
		`descr` mediumtext NOT NULL,
		PRIMARY KEY (`id`) 
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."courses` (
		`id` int NOT NULL AUTO_INCREMENT,
		`author` int NOT NULL,
		`status` varchar(30) NOT NULL,
		`privacy` varchar(30) NOT NULL,
		`title` varchar(50) NOT NULL,
		`descr` mediumtext NOT NULL,
		`category` int NOT NULL,
		`cover_pic` mediumtext NOT NULL,
		`secure` int NOT NULL,
		`secure_limit` int NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."results` (
		`id` int NOT NULL AUTO_INCREMENT,
		`status` varchar(20) NOT NULL,
		`course_id` int NOT NULL,
		`lesson_id` int NOT NULL,
		`test_id` int NOT NULL,
		`user_id` int NOT NULL,
		`result` mediumtext NOT NULL,
		`secure_result` int NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."negative_dmod` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		`dmod` mediumtext NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."positive_dmod` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		`dmod` mediumtext NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."delayed_auth_attempts` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		`course_id` int NOT NULL,
		`test_id` int NOT NULL,
		`keystroke_data` mediumtext NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."positive_data` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		`keycodes` mediumtext NOT NULL,
		`keystroke_data` mediumtext NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."negative_data` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		`keycodes` mediumtext NOT NULL,
		`keystroke_data` mediumtext NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."users_requiring_negatives` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id` int NOT NULL,
		PRIMARY KEY (`id`)
	);";
	mysql_query($sql);

	$sql = "INSERT INTO `".$dbPref."users` VALUES (
		1,
		3,
		'active',
		'$adminLogin',
		'$adminEmail',
		'$adminPass',
		'none',
		'".$adminControl."',
		'none',
		'',
		'',
		''
	);";
	mysql_query($sql);

	$sql = "CREATE TABLE `".$dbPref."user1_groups` (
		`group_id` int NOT NULL
	);";

	$sql = "CREATE TABLE `".$dbPref."user1_courses` (
		`course_id` int NOT NULL,
		`results` mediumtext NOT NULL
	);";

	$sql = "INSERT INTO `".$dbPref."config` VALUES (
		'site_name',
		'".$siteName."'
	);";
	mysql_query($sql);

	$sql = "INSERT INTO `".$dbPref."config` VALUES (
		'free_register',
		'true'
	);";
	mysql_query($sql);

	$sql = "INSERT INTO `".$dbPref."config` VALUES (
		'reg_role',
		'teacher'
	);";
	mysql_query($sql);

	$sql = "INSERT INTO `".$dbPref."config` VALUES (
		'student_edit_rights',
		'true'
	);";
	mysql_query($sql);

	header("location: /");