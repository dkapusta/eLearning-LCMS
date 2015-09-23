<?php
	if($user["role"]<2)
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
		<blockquote>Результаты прохождения курсов</blockquote>
		<p>
			Количество курсов, созданных Вами: 
			<?php
				$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `author` = ".$user["id"].";");
				$count = mysql_num_rows($r);
				echo $count;
			?>
		</p>
	</div>
</div>

<?php
	if($count > 0)
	{
		while($course = mysql_fetch_array($r))
		{
			?>
<div class="panel panel-primary">
	<div class="panel-heading">Курс "<?php echo $course["title"]; ?>"</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<a href="/course/<?php echo $course["id"]; ?>">Открыть</a>
					</div>
					<div class="panel-footer">Страница курса</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php
							$q = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_users`;");
							$count = mysql_num_rows($q);
							echo $count;
						?>
					</div>
					<div class="panel-footer">Записалось</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php
							$q = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_materials`;");
							$count = mysql_num_rows($q);
							echo $count;
						?>
					</div>
					<div class="panel-footer">Теоретические материалы</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default text-center">
					<div class="panel-body">
						<?php
							$q = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_tests`;");
							$count = mysql_num_rows($q);
							echo $count;
						?>
					</div>
					<div class="panel-footer">Тесты</div>
				</div>
			</div>
		</div>

		<?php
			if($count > 0)
			{
				while($test = mysql_fetch_array($q))
				{
					?>
		<div class="panel panel-info">
			<div class="panel-heading">Тест "<?php echo $test["title"]; ?>"</div>
			<div class="panel-body">
				<?php
					$z = mysql_query("SELECT * FROM `".$config["dbPref"]."results` WHERE `course_id` = ".$course["id"]." AND `test_id` = ".$test["id"]." AND `status` != 'deleted' ORDER BY `status` DESC;");
					if(mysql_num_rows($z) > 0)
					{
						if($course["secure"]==1)
						{
							?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Пользователь</th>
							<th>Результат</th>
							<th>Статус</th>
							<th>Подлинность</th>
							<th>Действия</th>
						</tr>
					</thead>

					<tbody>
						<?php
							$res_count = 0;
							while($result = mysql_fetch_array($z))
							{
								$res_count++;
								?>
						<tr>
							<td><?php echo $res_count; ?></td>
							<td>
								<?php
									$d = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` = ".$result["user_id"].";");
									$res_user = mysql_fetch_array($d);
									echo $res_user["login"];

									if($res_user["first_name"] || $res_user["last_name"])
									{
										echo " (".$res_user["first_name"]." ".$res_user["last_name"].")";
									}
								?>
							</td>
							<td>
								<?php
									$ans = json_decode($result["result"]);

									$score = $ans->score;
									$max = $ans->max_score;
									$percent = round($score / ($max / 100));

									echo $percent."% (".$score." из ".$max.")";
								?>
							</td>
							<td>
								<?php
									switch($result["status"])
									{
										case "approved":
											echo "Одобрен";
											break;

										case "pending":
											echo "Ожидает одобрения";
											break;
									}
								?>
							</td>
							<td>
								<?php
									$secure_result = $result["secure_result"];

									if($secure_result == -1)
									{
										?>
								<button result-id="<?php echo $result["id"]; ?>" course-id="<?php echo $course["id"]; ?>" user-id="<?php echo $result["user_id"]; ?>" test-id="<?php echo $test["id"]; ?>" class="btn btn-link secureTryAgain">Не удалось проверить. Попробовать снова.</button>
										<?
									}
									else
									{
										?>
								<span class="<?php echo $secure_result >= $course["secure_limit"] ? "label label-success" : "label label-danger"; ?>">
									<?php
										echo $secure_result."%";
									?>
								</span>
										<?
									}
								?>
							</td>
							<td>
								<?php
									if($result["status"]=="pending")
									{
										?>
								<button class="btn btn-success btn-xs approveResultBtn" title="Одобрить результат" result-id="<?php echo $result["id"]; ?>"><span class="glyphicon glyphicon-ok"></span></button>
										<?
									}
								?>
								<button class="btn btn-danger btn-xs deleteResultBtn" title="Удалить результат" result-id="<?php echo $result["id"]; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Пользователь</th>
							<th>Результат</th>
							<th>Статус</th>
							<th>Действия</th>
						</tr>
					</thead>

					<tbody>
						<?php
							$res_count = 0;
							while($result = mysql_fetch_array($z))
							{
								$res_count++;
								?>
						<tr>
							<td><?php echo $res_count; ?></td>
							<td>
								<?php
									$d = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` = ".$result["user_id"].";");
									$res_user = mysql_fetch_array($d);
									echo $res_user["login"];

									if($res_user["first_name"] || $res_user["last_name"])
									{
										echo " (".$res_user["first_name"]." ".$res_user["last_name"].")";
									}
								?>
							</td>
							<td>
								<?php
									$ans = json_decode($result["result"]);

									$score = $ans->score;
									$max = $ans->max_score;
									$percent = round($score / ($max / 100));

									echo $percent."% (".$score." из ".$max.")";
								?>
							</td>
							<td>
								<?php
									switch($result["status"])
									{
										case "approved":
											echo "Одобрен";
											break;

										case "pending":
											echo "Ожидает одобрения";
											break;
									}
								?>
							</td>
							<td>
								<?php
									if($result["status"]=="pending")
									{
										?>
								<button class="btn btn-success btn-xs approveResultBtn" title="Одобрить результат" result-id="<?php echo $result["id"]; ?>"><span class="glyphicon glyphicon-ok"></span></button>
										<?
									}
								?>
								<button class="btn btn-danger btn-xs deleteResultBtn" title="Удалить результат" result-id="<?php echo $result["id"]; ?>"><span class="glyphicon glyphicon-trash"></span></button>
							</td>
						</tr>
								<?
							}
						?>
					</tbody>
				</table>
							<?
						}
					}
					else
					{
						?>
				<div class="alert alert-warning">Этот тест пока никто не проходил</div>
						<?
					}
				?>
			</div>
		</div>
					<?
				}
			}
			else
			{
				?>
		<div class="alert alert-warning">На этом курсе нет ни одного теста</div>
				<?
			}
		?>
	</div>
</div>
			<?
		}
	}
	else
	{
		?>
<div class="alert alert-warning">Вы не создали ни одного курса</div>
		<?
	}
?>
		<?
	}