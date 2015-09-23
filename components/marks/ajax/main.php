<?php
	$type = $_GET["type"];

	if($type == "delete_result")
	{
		$id = $_POST["id"];

		mysql_query("UPDATE `".$config["dbPref"]."results` SET `status` = 'deleted' WHERE `id` = ".$id.";");

		echo "success";
	}
	else if($type == "approve_result")
	{
		$id = $_POST["id"];

		mysql_query("UPDATE `".$config["dbPref"]."results` SET `status` = 'approved' WHERE `id` = ".$id.";");

		echo "success";
	}
	else if($type == "update_result")
	{
		$id = $_POST["id"];
		$secure = $_POST["secure"];

		mysql_query("UPDATE `".$config["dbPref"]."results` SET `secure_result` = ".$secure." WHERE `id` = ".$id.";");

		echo "success";
	}