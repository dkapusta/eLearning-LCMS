<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Мой прогресс</blockquote>

<?php 
	$courses_query = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `status` = 'active';");

	if(mysql_num_rows($courses_query) < 1)
	{
?>
		<div class="alert alert-warning">Ни одного курса ещё не создано</div>
<?
	}
	else
	{
		$my_courses = 0;

		while($course = mysql_fetch_array($courses_query))
		{
			$usrs_query = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_users` WHERE `user_id` = ".$user["id"].";");
			if(mysql_num_rows($usrs_query) > 0)
			{
				$my_courses++;
?>
		<div class="panel panel-primary">
			<div class="panel-heading">Курс "<?php echo $course["title"]; ?>"</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
<?php
				$tests_query = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_tests` WHERE `status` = 'active';");
				$tests_count = mysql_num_rows($tests_query);
				$tests_passed = 0;

				if($tests_count > 0)
				{
?>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Название</th>
									<th>Результат</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
<?
					while($test = mysql_fetch_array($tests_query))
					{
?>
								<tr>
									<td><? echo $test["title"]; ?></td>
									<td>
<?
						$result_query = mysql_query("SELECT * FROM `".$config["dbPref"]."results` WHERE `status` = 'approved' AND `user_id` = ".$user["id"]." AND `test_id` = ".$test["id"]." AND `course_id` = ".$course["id"].";");

						$have_result = 0;
						if(mysql_num_rows($result_query) > 0) $have_result = 1;

						if($have_result==1)
						{
							$result = mysql_fetch_array($result_query);

							$res = json_decode($result["result"]);
							$score = $res->score;
							$max_score = $res->max_score;
							$percent = round( $score / ($max_score / 100) );

							if($percent > 74) $tests_passed++;

							$label_class = $percent > 74 ? "label label-success" : "label label-danger";

?>
										<div class="<? echo $label_class; ?>"><? echo $percent."%"; ?></div>
<?
						}
						else
						{
?>
										<div class="label label-info">Не пройден</div>
<?
						}
?>
									</td>
									<td>
<?
						if($have_result == 1)
						{
							?>
										<a href="/results?id=<? echo $result["id"]; ?>">Подробнее</a>
							<?
						}
?>
									</td>
								</tr>
<?
					}
?>
							</tbody>
						</table>
<?
				}
				else
				{
?>
						<div class="alert alert-warning">В этом курсе нет ни одного теста</div>
<?
				}
?>
					</div>

					<div class="col-md-4">
<?
				$tests_percent = 0;

				if($tests_count > 0)
				{
					$tests_percent = round( $tests_passed / ($tests_count / 100) );
				}
				
				$panel_class = $tests_percent==100 ? "panel panel-success" : "panel panel-info";
?>
						<div class="<? echo $panel_class; ?>">
							<div class="panel-heading text-center">Результат</div>
							<div class="panel-body">
								<?
									if($tests_percent > 75)
									{

								?>
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $tests_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tests_percent."%"; ?>;">	
									Курс пройден на <?php echo $tests_percent."%"; ?>
								</div>
								<?
									}
									else
									{
										?>
								<div class="well text-center">
									Курс пройден на <?php echo $tests_percent."%"; ?>
								</div>
										<?
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel-footer text-center">
				<a href="/course/<? echo $course["id"]; ?>" class="btn btn-default">Открыть курс</a>
			</div>
		</div>
<?
			}
		}

		if(!$my_courses)
		{
			?>
		<div class="alert alert-warning">
			Вы пока не записались ни на один курс
		</div>
			<?
		}	
	}
?>
	</div> <!-- panel-body -->
</div>