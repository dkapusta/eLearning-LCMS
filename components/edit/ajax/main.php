<?php
	$type = $_GET["type"];

	if($type=="save_user")
	{
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$pass = $_POST["pass"];
		$id = $user["id"];

		if($first_name)
		{
			mysql_query("UPDATE `".$config["dbPref"]."users` SET `first_name` = '".$first_name."' WHERE `id` = ".$id.";");
		}
		if($last_name)
		{
			mysql_query("UPDATE `".$config["dbPref"]."users` SET `last_name` = '".$last_name."' WHERE `id` = ".$id.";");
		}
		if($pass)
		{
			mysql_query("UPDATE `".$config["dbPref"]."users` SET `pass` = '".md5($pass)."' WHERE `id` = ".$id.";");
		}

		echo "success";
	}