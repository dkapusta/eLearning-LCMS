<?php
	$type = $_GET["type"];

	if($type == "new_course")
	{
		$title = htmlspecialchars($_POST["title"]);
		$descr = htmlspecialchars($_POST["descr"]);
		$category = $_POST["category"];
		$secure = $_POST["secure"];
		$limit = $_POST["limit"] ? $_POST["limit"] : 0;
		$privacy = $_POST["privacy"];

		session_start();
		$author = $_SESSION["eLearn_uid"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses`;");
		$id = mysql_num_rows($r) + 1;

		$sql = "INSERT INTO `".$config["dbPref"]."courses` VALUES (
			".$id.",
			".$author.",
			'active',
			'".$privacy."',
			'".$title."',
			'".$descr."',
			".$category.",
			'none',
			".$secure.",
			".$limit."
		);";
		mysql_query($sql);

		$sql = "CREATE TABLE `".$config["dbPref"]."course_".$id."_lessons` (
			`id` int NOT NULL,
			`status` varchar(20) NOT NULL,
			`title` varchar(50) NOT NULL,
			`descr` text NOT NULL,
			PRIMARY KEY (`id`)
		);";
		mysql_query($sql);

		$sql = "CREATE TABLE `".$config["dbPref"]."course_".$id."_users` (
			`id` int NOT NULL,
			`user_id` int NOT NULL,
			PRIMARY KEY (`id`)
		);";
		mysql_query($sql);

		$sql = "CREATE TABLE `".$config["dbPref"]."course_".$id."_materials` (
			`id` int NOT NULL,
			`status` varchar(30) NOT NULL,
			`lesson_id` int NOT NULL,
			`title` varchar(30) NOT NULL,
			`descr` text NOT NULL,
			`type` varchar(20) NOT NULL,
			`content` text NOT NULL,
			PRIMARY KEY (`id`)
		);";
		mysql_query($sql);

		$sql = "CREATE TABLE `".$config["dbPref"]."course_".$id."_tests` (
			`id` int NOT NULL,
			`status` varchar(30) NOT NULL,
			`lesson_id` int NOT NULL,
			`title` varchar(30) NOT NULL,
			`descr` text NOT NULL,
			`type` varchar(20) NOT NULL,
			`content` text NOT NULL,
			PRIMARY KEY (`id`)
		);";
		mysql_query($sql);

		echo "success";
	}
	else if($type=="delete_course")
	{
		$id = $_POST["id"];

		mysql_query("UPDATE `".$config["dbPref"]."courses` SET `status` = 'deleted' WHERE `id` = ".$id.";");

		echo "success";
	}