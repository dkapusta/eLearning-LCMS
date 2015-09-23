<?php
	$course_id = $id[0];
	if($course_id == "view")
	{
		$course_id = 0;
	}
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `id` = ".$course_id.";");
	$course = mysql_fetch_array($r);

	if($course["status"] != "active")
	{
		?>
<div class="alert alert-danger">
	Такого курса не существует!
</div>
		<?
	}
	else
	{
		?>
<div id="captcha" style="display: none;" course-id="<?php echo $course["id"]; ?>" user-id="<?php echo $user["id"]; ?>"></div>
<div class="panel panel-default">
	<div class="panel-body">
		<blockquote><?php echo $course["title"]; ?></blockquote>

		<div class="row">
			<div class="col-md-9">
				<p>
					Категория:
					<?php
						if($course["category"] == 0)
						{
							?>
					<a href="/courses">Без категории</a>
							<?
						}
						else
						{
							$z = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `id` = ".$course["category"].";");
							$categ = mysql_fetch_array($z);
							?>
					<a href="/courses?categoryId=<?php echo $course["category"]; ?>"><?php echo $categ["title"]; ?></a>
							<?
						}
					?>
				</p>
				<p>
					<?php echo $course["descr"]; ?>
				</p>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-body">
						<p class="text-center">
							<?php
								$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_users`;");
								$users_count = mysql_num_rows($r);
							?>
							<span class="glyphicon glyphicon-user"></span> <?php echo $users_count; ?>
						</p>

						<?php
							$z = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_users` WHERE `user_id` = ".$user["id"].";");

							$applied = 0;

							if(mysql_num_rows($z) > 0)
							{
								$applied = 1;

								$resp = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_tests` WHERE `status` = 'active';");
								if(mysql_num_rows($resp) > 0)
								{
									$all_done = 1;

									while($test = mysql_fetch_array($resp))
									{
										$resp1 = mysql_query("SELECT * FROM `".$config["dbPref"]."results` WHERE `user_id` = ".$user["id"]." AND `course_id` = ".$course_id." AND `test_id` = ".$test["id"]." AND `status` = 'approved';");
										if(mysql_num_rows($resp1) < 1)
										{
											$all_done = 0;
										}
									}

									if($all_done == 1)
									{
										?>
						<div class="alert alert-success text-center">Курс пройден</div>
										<?
									}
									else
									{
										?>
						<div class="alert alert-info text-center">Вы уже записаны на этот курс</div>
										<?
									}
								}
								else
								{
									?>
						<div class="alert alert-info text-center">Вы уже записаны на этот курс</div>
									<?
								}
							}
							else
							{
								?>
						<button id="applyForCourseBtn" class="btn btn-primary btn-block" secure-data="<?php echo $course["secure"]; ?>" user-id="<?php echo $user["id"]; ?>" course-id="<?php echo $course_id; ?>">Записаться</button>
								<?
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_lessons` WHERE `status` = 'active';");
	if(mysql_num_rows($r) < 1 && $applied==1)
	{
		?>
<div class="alert alert-warning">В этом курсе нет ни одного урока</div>
		<?
	}
	else if($applied==1)
	{
		$lessons_count = 0;
		while($lesson = mysql_fetch_array($r))
		{
			$lessons_count++;
			?>
<div class="panel panel-primary">
	<div class="panel-heading">Урок №<?php echo $lessons_count; ?>: <?php echo $lesson["title"]; ?></div>

	<div class="panel-body">
		<div class="well"><?php echo $lesson["descr"]; ?></div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<blockquote>Теоретические материалы</blockquote>
						<?php
							$z = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_materials` WHERE `status` = 'active' AND `lesson_id` = ".$lesson["id"].";");
							if(mysql_num_rows($z) < 1)
							{
								?>
						<div class="alert alert-warning">В этом уроке нет теоретических материалов</div>
								<?
							}
							else
							{
								while($material = mysql_fetch_array($z))
								{
									?>
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $material["title"]; ?></div>
							<div class="panel-body">
								<?php echo $material["descr"]; ?>

								<hr/>

								<button material-id="<?php echo $material["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-info viewMaterialBtn2">Посмотреть</button>
							</div>
						</div>
									<?
								}
							}
						?>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<blockquote>Тесты</blockquote>
						<?php
							$z = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_tests` WHERE `status` = 'active' AND `lesson_id` = ".$lesson["id"].";");
							if(mysql_num_rows($z) < 1)
							{
								?>
						<div class="alert alert-warning">В этом уроке нет тестов</div>
								<?
							}
							else
							{
								while($test = mysql_fetch_array($z))
								{
									?>
						<div class="panel panel-info">
							<div class="panel-heading"><?php echo $test["title"]; ?></div>
							<div class="panel-body">
								<?php echo $test["descr"]; ?>

								<hr/>

								<?php
									$w = mysql_query("SELECT * FROM `".$config["dbPref"]."results` WHERE `user_id` = ".$user["id"]." AND `course_id` = ".$course["id"]." AND `test_id` = ".$test["id"]." AND `status` != 'deleted';");
									if(mysql_num_rows($w) > 0)
									{
										$reslt = mysql_fetch_array($w);
										?>
								<a href="/results?id=<?php echo $reslt["id"]; ?>" class="btn <?php echo $reslt["status"]=="approved" ? "btn-success" : "btn-warning"; ?>">Посмотреть результат</a>
										<?
									}
									else
									{
										?>
								<button user-id="<?php echo $user["id"]; ?>" secure="<?php echo $course["secure"]; ?>" test-id="<?php echo $test["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-info openTestBtn">Пройти</button>
										<?
									}
								?>
								
							</div>
						</div>
									<?
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			<?
		}
	}
?>
		<?
	}