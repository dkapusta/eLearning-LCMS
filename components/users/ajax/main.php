<?php
	$type = $_GET["type"];

	if($type=="new_user")
	{
		$login = $_POST["login"];
		$email = $_POST["email"];
		$pass = md5($_POST["pass"]);
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$role = $_POST["role"];
		$control = $_POST["control"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users`;");
		$id = mysql_num_rows($r) + 1;

		$sql = "INSERT INTO `".$config["dbPref"]."users` VALUES (
			".$id.",
			".$role.",
			'active',
			'".$login."',
			'".$email."',
			'".$pass."',
			'".md5(time())."',
			'".$control."',
			'pic',
			'".$first_name."',
			'".$last_name."',
			'about'
		);";
		mysql_query($sql);

		echo "success";
	}
	else if($type=="delete_user")
	{
		$id = $_POST["id"];

		mysql_query("UPDATE `".$config["dbPref"]."users` SET `status` = 'deleted' WHERE `id` = ".$id.";");

		echo "success";
	}
	else if($type=="edit_user")
	{
		$id = $_POST["id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` = ".$id.";");
		$data = mysql_fetch_array($r);

		$resp = array(
			"id" => $id,
			"login" => $data["login"],
			"email" => $data["email"],
			"role" => $data["role"],
			"first_name" => $data["first_name"],
			"last_name" => $data["last_name"],
			"secret_code" => $data["secret_code"]
		);

		echo json_encode($resp);
	}
	else if($type=="update_user")
	{
		$id = $_POST["id"];
		$login = $_POST["login"];
		$email = $_POST["email"];
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$role = $_POST["role"];
		$pass = $_POST["pass"];

		if($pass)
		{
			$pass = md5($pass);
			mysql_query("UPDATE `".$config["dbPref"]."users` SET `pass` = '".$pass."' WHERE `id` = ".$id.";");
		}

		mysql_query("UPDATE `".$config["dbPref"]."users` SET `email` = '".$email."' WHERE `id` = ".$id.";");
		mysql_query("UPDATE `".$config["dbPref"]."users` SET `first_name` = '".$first_name."' WHERE `id` = ".$id.";");
		mysql_query("UPDATE `".$config["dbPref"]."users` SET `last_name` = '".$last_name."' WHERE `id` = ".$id.";");
		mysql_query("UPDATE `".$config["dbPref"]."users` SET `role` = '".$role."' WHERE `id` = ".$id.";");

		echo "success";
	}