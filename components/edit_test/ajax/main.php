<?php
	$type = $_GET["type"];

	switch($type)
	{
		case "save_test":
			$course_id = $_POST["course_id"];
			$test_id = $_POST["test_id"];
			$title = htmlspecialchars($_POST["title"]);
			$descr = htmlspecialchars($_POST["descr"]);

			if($title)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_tests` SET `title` = '".$title."' WHERE `id` = ".$test_id.";");
			}

			if($descr)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_tests` SET `descr` = '".$descr."' WHERE `id` = ".$test_id.";");
			}

			echo "success";
			break;

		case "add_question":
			$course_id = $_POST["course_id"];
			$test_id = $_POST["test_id"];
			$text = htmlspecialchars($_POST["text"]);
			$type = htmlspecialchars($_POST["type"]);
			$var1 = htmlspecialchars($_POST["var1"]);
			$var2 = htmlspecialchars($_POST["var2"]);
			$var3 = htmlspecialchars($_POST["var3"]);
			$var4 = htmlspecialchars($_POST["var4"]);
			$answer = htmlspecialchars($_POST["answer"]);

			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions`;");
			$id = mysql_num_rows($r) + 1;

			$sql = "INSERT INTO `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` VALUES (
				".$id.",
				'active',
				'".$type."',
				'".$text."',
				'".$var1."',
				'".$var2."',
				'".$var3."',
				'".$var4."',
				'".$answer."'
			);";
			mysql_query($sql);

			echo "success";
			break;

		case "delete_question":
			$course_id = $_POST["course_id"];
			$test_id = $_POST["test_id"];
			$question_id = $_POST["question_id"];

			mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `status` = 'deleted' WHERE `id` = ".$question_id.";");

			echo "success";
			break;

		case "get_question":
			$course_id = $_POST["course_id"];
			$test_id = $_POST["test_id"];
			$question_id = $_POST["question_id"];

			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` WHERE `id` = ".$question_id.";");
			$data = mysql_fetch_array($r);

			$resp = array(
				"question" => $data["question"],
				"type" => $data["type"],
				"var1" => $data["var1"],
				"var2" => $data["var2"],
				"var3" => $data["var3"],
				"var4" => $data["var4"],
				"answer" => $data["answer"]
			);

			echo json_encode($resp);
			break;

		case "save_question":
			$course_id = $_POST["course_id"];
			$test_id = $_POST["test_id"];
			$question_id = $_POST["question_id"];

			$text = htmlspecialchars($_POST["text"]);
			$var1 = htmlspecialchars($_POST["var1"]);
			$var2 = htmlspecialchars($_POST["var2"]);
			$var3 = htmlspecialchars($_POST["var3"]);
			$var4 = htmlspecialchars($_POST["var4"]);
			$answer = htmlspecialchars($_POST["answer"]);

			if($text)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `question` = '".$text."' WHERE `id` = ".$question_id.";");
			}
			if($var1)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `var1` = '".$var1."' WHERE `id` = ".$question_id.";");
			}
			if($var2)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `var2` = '".$var2."' WHERE `id` = ".$question_id.";");
			}
			if($var3)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `var3` = '".$var3."' WHERE `id` = ".$question_id.";");
			}
			if($var4)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `var4` = '".$var4."' WHERE `id` = ".$question_id.";");
			}
			if($answer)
			{
				mysql_query("UPDATE `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` SET `answer` = '".$answer."' WHERE `id` = ".$question_id.";");
			}

			echo "success";
			break;
	}