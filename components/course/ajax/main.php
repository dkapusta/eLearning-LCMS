<?php
	$type = $_GET["type"];
	$course_id = $id[0];

	if($type == "apply")
	{
		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_users` WHERE `user_id` = ".$user["id"].";");
		if(mysql_num_rows($r) < 1)
		{
			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_users`;");
			$id = mysql_num_rows($r) + 1;

			mysql_query("INSERT INTO `".$config["dbPref"]."course_".$course_id."_users` VALUES (".$id.", ".$user["id"].");");

			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users_requiring_negatives` WHERE `user_id` = ".$user["id"].";");
			if(mysql_num_rows($r) < 1)
			{
				$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users_requiring_negatives`;");
				$id = mysql_num_rows($r) + 1;
				mysql_query("INSERT INTO `".$config["dbPref"]."users_requiring_negatives` VALUES (".$id.", ".$user["id"].");");
			}

			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	else if($type=="get_course")
	{
		$course_id = $_POST["course_id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `id` = ".$course_id.";");
		$data = mysql_fetch_array($r);

		$resp = array(
			"secure" => $data["secure"]
		);
		echo json_encode($resp);
	}
	else if($type=="get_test")
	{
		$course_id = $_POST["course_id"];
		$test_id = $_POST["test_id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_tests` WHERE `id` = ".$test_id.";");
		$data = mysql_fetch_array($r);

		$resp = array(
			"title" => $data["title"]
		);
		echo json_encode($resp);
	}
	else if($type=="load_questions")
	{
		$course_id = $_POST["course_id"];
		$test_id = $_POST["test_id"];

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` WHERE `status` = 'active';");
		if(mysql_num_rows($r) > 0)
		{
			$resp = array();

			while($data = mysql_fetch_array($r))
			{
				$question = array(
					"id" => $data["id"],
					"question" => $data["question"],
					"type" => $data["type"],
					"var1" => $data["var1"],
					"var2" => $data["var2"],
					"var3" => $data["var3"],
					"var4" => $data["var4"]
				);

				array_push($resp, $question);
			}

			echo json_encode($resp);
		}
	}
	else if($type=="send_results")
	{
		$course_id = $_POST["course_id"];
		$test_id = $_POST["test_id"];
		$secure = $_POST["secure"];
		$secure_result = $_POST["secure_result"];
		$answers = $_POST["answers"];
		$questions = $_POST["questions"];

		$score = 0;
		$max_score = count($questions);
		for($i=0; $i<count($questions); $i++)
		{
			$sql = "SELECT * FROM `".$config["dbPref"]."course_".$course_id."_test_".$test_id."_questions` WHERE `id` = ".$questions[$i]["id"].";";
			$r = mysql_query($sql);
			$data = mysql_fetch_array($r);

			if($data["answer"]==$answers[$i]) $score++;
		}

		$result = array(
			"score" => $score,
			"max_score" => $max_score,
			"answers" => $answers,
			"questions" => $questions
		);

		if($secure == "1")
		{
			$status = "pending";
		}
		else
		{
			$percent = round($score / ($max_score / 100));

			if($percent > 74)
			{
				$status = "approved";
			}
			else
			{
				$status = "pending";
			}
		}

		$r = mysql_query("SELECT * FROM `".$config["dbPref"]."results`;");
		$id = mysql_num_rows($r) + 1;

		$sql = "INSERT INTO `".$config["dbPref"]."results` VALUES (
			".$id.",
			'".$status."',
			".$course_id.",
			0,
			".$test_id.",
			".$user["id"].",
			'".json_encode($result)."',
			".$secure_result."
		);";
		mysql_query($sql);

		echo json_encode(array("id" => $id));
	}