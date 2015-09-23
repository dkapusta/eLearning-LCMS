<?php
	class AuthHandler
	{
		function AuthHandler()
		{

		}

		function checkAuth($conf)
		{
			session_start();

			$auth = 0;

			if($_SESSION["eLearn_uid"] && $_SESSION["eLearn_token"])
			{
				mysql_connect($conf["dbHost"], $conf["dbUser"], $conf["dbPass"]);
				mysql_select_db($conf["dbName"]);

				mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8';");

				$r = mysql_query("SELECT * FROM `".$conf["dbPref"]."users` WHERE `id` = ".$_SESSION["eLearn_uid"]);
				if(mysql_num_rows($r))
				{
					$data = mysql_fetch_array($r);

					if($_SESSION["eLearn_token"] == $data["token"])
					{
						$auth = 1;
					}
				}
			}

			return $auth;
		}
	}