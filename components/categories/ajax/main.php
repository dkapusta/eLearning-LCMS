<?php
	$type = $_GET["type"];

	if($type=="new_category")
	{
		$title = htmlspecialchars($_POST["title"]);
		$descr = htmlspecialchars($_POST["descr"]);

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories`;");
		$id = mysql_num_rows($r) + 1;

		mysql_query("INSERT INTO `".$config["dbPref"]."categories` VALUES (
			".$id.",
			'active',
			'".$title."',
			'".$descr."'
		);");

		echo "success";
	}
	else if($type=="get_category")
	{
		$id = $_POST["id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `id` = ".$id.";");
		$data = mysql_fetch_array($r);

		$resp = array("title" => $data["title"], "descr" => $data["descr"]);
		echo json_encode($resp);
	}
	else if($type=="edit_category")
	{
		$id = htmlspecialchars($_POST["id"]);
		$title = htmlspecialchars($_POST["title"]);
		$descr = htmlspecialchars($_POST["descr"]);

		mysql_query("UPDATE `".$config["dbPref"]."categories` SET `title` = '".$title."', `descr` = '".$descr."' WHERE `id` = ".$id.";");
		echo "success";
	}
	else if($type=="delete_category")
	{
		$id = htmlspecialchars($_POST["id"]);

		mysql_query("UPDATE `".$config["dbPref"]."categories` SET `status` = 'deleted' WHERE `id` = ".$id.";");
		echo "success";
	}