<?php
	$mode = $_GET["mode"];

	if($mode == "auth")
	{
		$authLogin = $_POST["authLogin"];
		$authPass = md5($_POST["authPass"]);

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `login` = '".$authLogin."';");

		if(mysql_num_rows($r) > 0)
		{
			$data = mysql_fetch_array($r);
				
			if($data["pass"] == $authPass)
			{
				session_start();

				$token = md5("123".time().$data["id"]);

				$_SESSION["eLearn_uid"] = $data["id"];
				$_SESSION["eLearn_token"] = $token;

				mysql_query("UPDATE `".$config["dbPref"]."users` SET `token` = '".$token."' WHERE `id` = ".$data["id"].";");

				echo "success";
			}
			else
			{
				echo "error";
			}
		}
		else
		{
			echo "error";
		}
	}
	else if($mode == "reg")
	{
		$login = htmlspecialchars($_POST["regLogin"]);
		$email = htmlspecialchars($_POST["regEmail"]);
		$pass = md5($_POST["regPass"]);
		$control = $_POST["regControl"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `login` = '".$login."';");
		if(mysql_num_rows($r) < 1)
		{
			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users`;");
			$id = mysql_num_rows($r) + 1;

			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'reg_role';");
			$role = mysql_fetch_array($r);
			$role = $role["value"]=="teacher" ? 2 : 1;

			session_start();
			$token = md5(time().$login);
			$_SESSION["eLearn_uid"] = $id;
			$_SESSION["eLearn_token"] = $token;

			$sql = "INSERT INTO `".$config["dbPref"]."users` VALUES (
				".$id.",
				".$role.",
				'active',
				'".$login."',
				'".$email."',
				'".$pass."',
				'".$token."',
				'".$control."',
				'pic',
				'',
				'',
				''
			);";
			mysql_query($sql);

			echo "success";
		}
		else
		{
			echo "error";
		}
	}