<?php
	$type = $_GET["type"];
	$id = $_GET["id"];

	if($type=="save_course")
	{
		$title = htmlspecialchars($_POST["title"]);
		$descr = htmlspecialchars($_POST["descr"]);
		$category = $_POST["category"];
		$privacy = $_POST["privacy"];
		
		if($title)
		{
			mysql_query("UPDATE `".$config["dbPref"]."courses` SET `title` = '".$title."' WHERE `id` = ".$id.";") or die("Nope");
		}

		if($descr)
		{
			mysql_query("UPDATE `".$config["dbPref"]."courses` SET `descr` = '".$descr."' WHERE `id` = ".$id.";");
		}

		if($category || $category == 0)
		{
			mysql_query("UPDATE `".$config["dbPref"]."courses` SET `category` = ".$category." WHERE `id` = ".$id.";");
		}

		mysql_query("UPDATE `".$config["dbPref"]."courses` SET `privacy` = '".$privacy."' WHERE `id` = ".$id.";");

		echo "success";
	}
	else if($type=="add_lesson")
	{
		$id = $_POST["id"];
		$title = $_POST["title"];
		$descr = $_POST["descr"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_lessons`;");
		$n = mysql_num_rows($r) + 1;
		mysql_query("INSERT INTO `".$config["dbPref"]."course_".$id."_lessons` VALUES (
			".$n.",
			'active',
			'".$title."',
			'".$descr."'
		);");

		echo "success";
	}
	else if($type=="get_lesson_info")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_lessons` WHERE `id` = ".$lesson.";");
		$data = mysql_fetch_array($r);
		$resp = array(
			"title" => $data["title"],
			"descr" => $data["descr"]
		);

		echo json_encode($resp);
	}
	else if($type=="update_lesson")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];
		$title = htmlspecialchars($_POST["title"], ENT_QUOTES);
		$descr = htmlspecialchars($_POST["descr"], ENT_QUOTES);

		$sql = "UPDATE `".$config["dbPref"]."course_".$id."_lessons` SET `title` = '".$title."', `descr` = '".$descr."' WHERE `id` = ".$lesson.";";

		mysql_query($sql);

		echo "success";
	}
	else if($type=="delete_lesson")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];

		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_lessons` SET `status` = 'deleted' WHERE `id` = ".$lesson.";");

		echo "success";
	}
	else if($type=="add_text_material")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];

		$title = htmlspecialchars($_POST["title"], ENT_QUOTES);
		$descr = htmlspecialchars($_POST["descr"], ENT_QUOTES);
		$content = htmlspecialchars($_POST["content"], ENT_QUOTES);

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_materials`;");
		$n = mysql_num_rows($r) + 1;

		$sql = "INSERT INTO `".$config["dbPref"]."course_".$id."_materials` VALUES (
			".$n.",
			'active',
			".$lesson.",
			'".$title."',
			'".$descr."',
			'text',
			'".$content."'
		);";
		mysql_query($sql);

		echo "success";
	}
	else if($type=="add_embed_material")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];

		$title = htmlspecialchars($_POST["title"], ENT_QUOTES);
		$descr = htmlspecialchars($_POST["descr"], ENT_QUOTES);
		$content = htmlspecialchars($_POST["content"], ENT_QUOTES);

		$type = $_POST["type"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_materials`;");
		$n = mysql_num_rows($r) + 1;

		$sql = "INSERT INTO `".$config["dbPref"]."course_".$id."_materials` VALUES (
			".$n.",
			'active',
			".$lesson.",
			'".$title."',
			'".$descr."',
			'".$type."',
			'".$content."'
		);";
		mysql_query($sql);

		echo "success";
	}
	else if($type=="get_material_info")
	{
		$id = $_POST["course_id"];
		$material = $_POST["material_id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_materials` WHERE `id` = ".$material.";");
		$data = mysql_fetch_array($r);

		$resp = array(
			"title" => htmlspecialchars_decode($data["title"], ENT_QUOTES),
			"descr" => htmlspecialchars_decode($data["descr"], ENT_QUOTES),
			"content" => htmlspecialchars_decode($data["content"], ENT_QUOTES)
		);
		echo json_encode($resp);
	}
	else if($type=="save_embed")
	{
		$id = $_POST["course_id"];
		$material = $_POST["material_id"];

		$title = htmlspecialchars($_POST["title"], ENT_QUOTES);
		$descr = htmlspecialchars($_POST["descr"], ENT_QUOTES);
		$content = htmlspecialchars($_POST["content"], ENT_QUOTES);

		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_materials` SET `title` = '".$title."' WHERE `id` = ".$material.";");
		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_materials` SET `descr` = '".$descr."' WHERE `id` = ".$material.";");
		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_materials` SET `content` = '".$content."' WHERE `id` = ".$material.";");

		echo "success";
	}
	else if($type=="delete_material")
	{
		$id = $_POST["course_id"];
		$material = $_POST["material_id"];

		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_materials` SET `status` = 'deleted' WHERE `id` = ".$material.";");

		echo "success";
	}
	else if($type=="add_test")
	{
		$id = $_POST["course_id"];
		$lesson = $_POST["lesson_id"];
		$title = htmlspecialchars($_POST["title"]);
		$descr = htmlspecialchars($_POST["descr"]);

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$id."_tests`;");
		$n = mysql_num_rows($r) + 1;

		mysql_query("INSERT INTO `".$config["dbPref"]."course_".$id."_tests` VALUES (
			".$n.",
			'active',
			".$lesson.",
			'".$title."',
			'".$descr."',
			'type',
			'content'
		);");

		mysql_query("CREATE TABLE `".$config["dbPref"]."course_".$id."_test_".$n."_questions` (
			`id` int NOT NULL,
			`status` varchar(30) NOT NULL,
			`type` varchar(30) NOT NULL,
			`question` text NOT NULL,
			`var1` text NOT NULL,
			`var2` text NOT NULL,
			`var3` text NOT NULL,
			`var4` text NOT NULL,
			`answer` text NOT NULL,
			PRIMARY KEY (`id`)
		);");

		echo json_encode(array("id" => $n));
	}
	else if($type=="delete_test")
	{
		$id = $_POST["course_id"];
		$test = $_POST["test_id"];

		mysql_query("UPDATE `".$config["dbPref"]."course_".$id."_tests` SET `status` = 'deleted' WHERE `id` = ".$test.";");

		echo "success";
	}