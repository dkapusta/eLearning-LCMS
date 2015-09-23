<?php
	class Framework
	{
		public $LMSInstaller;
		public $AuthHandler;
		public $config;

		function Framework()
		{
			global $LMSInstaller, $AuthHandler;

			$LMSInstaller = new LMSInstaller();
			$AuthHandler = new AuthHandler();
		}

		function run()
		{
			global $LMSInstaller, $AuthHandler, $config;

			if($LMSInstaller->checkInstall() == 0)
			{
				$com = "install";

				if($_GET["act"] != "install" && $_GET["act"] != "ajax")
				{
					include "components/".$com."/main.php";
				}
				else if($_GET["act"] == "ajax")
				{
					include "components/".$com."/ajax/checkDB.php";
				}
				else
				{
					include "components/".$com."/action/install.php";
				}
			}
			else
			{
				$config = include "config.php";

				if($AuthHandler->checkAuth($config) == 0)
				{
					$com = "auth";

					mysql_connect($config["dbHost"], $config["dbUser"], $config["dbPass"]);
					mysql_select_db($config["dbName"]);

					mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8';");

					if($_GET["act"] == "ajax")
					{
						include "components/".$com."/ajax/auth.php";
					}
					else
					{
						include "components/".$com."/main.php";
					}
				}
				else
				{
					mysql_connect($config["dbHost"], $config["dbUser"], $config["dbPass"]);
					mysql_select_db($config["dbName"]);

					mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8';");

					$uri = $_SERVER["REQUEST_URI"];
					$uri = explode("/", $uri);
					if(!$uri[2]) $uri[2] = "view";
					if(!$uri[1]) $uri[1] = "profile";
					$com = explode("?", $uri[1]);
					$id = explode("?", $uri[2]);

					$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` = ".$_SESSION["eLearn_uid"].";");
					$user = mysql_fetch_array($r);

					if($_GET["act"] == "ajax")
					{
						include "components/".$com[0]."/ajax/main.php";
					}
					else
					{
						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'site_name';");
						$data = mysql_fetch_array($r);
						$site_title = $data["value"];

						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'student_edit_rights';");
						$data = mysql_fetch_array($r);
						$student_edit = $data["value"];

						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'free_register';");
						$data = mysql_fetch_array($r);
						$free_register = $data["value"];

						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'reg_role';");
						$data = mysql_fetch_array($r);
						$reg_role = $data["value"];

						include "components/template/header.php";
						include "components/".$com[0]."/modals.php";
						include "components/template/content.php";
						include "components/".$com[0]."/main.php";
						include "components/template/footer.php";
					}
				}
			}
		}
	}