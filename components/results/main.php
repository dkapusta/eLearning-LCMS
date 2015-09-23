<?php
	$id = $_GET["id"];

	$results_query = mysql_query("SELECT * FROM `".$config["dbPref"]."results` WHERE `id` = ".$id.";");
	$result = mysql_fetch_array($results_query);

	$test_query = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$result["course_id"]."_tests` WHERE `id` = ".$result["test_id"].";");
	$test = mysql_fetch_array($test_query);

	$course_query = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `id` = ".$result["course_id"].";");
	$course = mysql_fetch_array($course_query);

	$res = json_decode($result["result"]);

	$score = $res->score;
	$max = $res->max_score;
	$percent = $max / 100;
	$mark = round($score / $percent);

	$panel_class = $result["status"]=="approved" ? "panel panel-success" : ($course["privacy"] == "everyone" ? "panel panel-warning" : "panel panel-danger");

	if($user["id"] != $result["user_id"])
	{
?>
<div class="alert alert-danger">У Вас нет прав для просмотра этой страницы</div>
<?
	}
	else
	{
?>
<div class="panel panel-default">
	<div class="panel-body">
		<a href="/course/<?php echo $result["course_id"]; ?>" class="btn btn-primary">Назад к курсу</a>
	</div>
</div>

<div class="<?php echo $panel_class; ?>">
	<div class="panel-heading">Результаты теста "<?php echo $test["title"]; ?>"</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
<?php
		switch($result["status"])
		{
			case "approved":
				echo "Подтверждено";
				break;

			case "pending":
				echo "Ожидает подтверждения";
				break;
		}
?>
					</div>
					<div class="panel-footer">Статус</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php echo $mark."%"; ?>
					</div>
					<div class="panel-footer">Результат</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php echo $res->score; ?>
					</div>
					<div class="panel-footer">Баллы</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php echo $res->max_score; ?>
					</div>
					<div class="panel-footer">Макс. балл</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
		if($mark < 75)
		{
?>
<div class="panel panel-warning">
	<div class="panel-body text-center">
		Для успешного прохождения теста необходимо набрать <span class="label label-success">75%</span> правильных ответов. 
		Ваш результат: <span class="label label-danger"><?php echo $mark."%"; ?></span>.
<?php
			if($course["privacy"]=="everyone")
			{
?>
		<br/>
		Учитель может одобрить Ваш результат вручную, если использует другую систему оценивания.
		<br/>
		Также Вы можете удалить этот результат и попытаться пройти тест снова.
<?
			}
?>
	</div>
<?php
			if($course["privacy"]=="everyone")
			{
?>
	<div class="panel-footer text-center">
		<button id="deleteMark" class="btn btn-default" course-id="<?php echo $result["course_id"]; ?>" result-id="<?php echo $result["id"]; ?>">Удалить результат</button>
	</div>
<?php
			}
?>
</div>
<?
		}
	}