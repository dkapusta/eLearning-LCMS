<?php
	$var = $_GET["var"];

	mysql_query("UPDATE `".$config["dbPref"]."config` SET `value` = '".$_POST["value"]."' WHERE `key` = '".$var."';");

	echo "success";