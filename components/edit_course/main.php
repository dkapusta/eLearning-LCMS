<?php
	$course_id = $_GET["id"];
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `id` = ".$course_id.";");
	$course = mysql_fetch_array($r);

	if($user["role"] < 2 || $user["id"] != $course["author"]) 
	{
		?>
<div class="alert alert-danger">У Вас нет доступа к этой странице</div>
		<?
	}
	else
	{
		?>
<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Редактирование курса</blockquote>

		<form class="form-horizontal">
			<div class="form-group">
    			<label for="courseTitle" class="col-sm-2 control-label">Название</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="courseTitle" placeholder="" value="<?php echo htmlspecialchars_decode($course["title"]) ?>">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="courseDescr" class="col-sm-2 control-label">Описание</label>
    			<div class="col-sm-10">
      				<textarea class="form-control" id="courseDescr" rows="3"><?php echo htmlspecialchars_decode($course["descr"]) ?></textarea>
    			</div>
  			</div>
  			<div class="form-group">
  				<label for="coursePrivacy" class="col-sm-2 control-label">Дополнительно</label>
    			<div class="col-sm-10">
      				<select class="form-control" id="coursePrivacy">
      					<option value="everyone"<?php if($course["privacy"]=="everyone") echo " selected"; ?>>Разрешать пересдачу</option>
     					<option value="protected"<?php if($course["privacy"]=="protected") echo " selected"; ?>>Не разрешать пересдачу</option>
      				</select>
    			</div>
  			</div>
  			<div class="form-group">
  				<label for="courseCategory" class="col-sm-2 control-label">Категория</label>
    			<div class="col-sm-10">
      				<select class="form-control" id="courseCategory">
      					<option value="0"<?php if($course["category"]=="0") echo " selected"; ?>>Без категории</option>
      					<?php
      						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `status` = 'active';");
      						while($data = mysql_fetch_object($r))
      						{
      							?>
      					<option value="<?php echo $data->id; ?>"<?php if($course["category"]==$data->id) echo " selected"; ?>><?php echo $data->title; ?></option>
      							<?
      						}
      					?>
      				</select>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="button" class="btn btn-default" id="saveCourseBtn" course-id="<?php echo $course["id"]; ?>">Сохранить</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Добавить урок</blockquote>

		<form class="form-horizontal">
			<div class="form-group">
    			<label for="lessonTitle" class="col-sm-2 control-label">Название</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="lessonTitle" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="lessonDescr" class="col-sm-2 control-label">Описание</label>
    			<div class="col-sm-10">
      				<textarea class="form-control" id="lessonDescr" rows="3"></textarea>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="button" class="btn btn-default" id="addLessonBtn" course-id="<?php echo $course["id"]; ?>">Добавить</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Уроки</blockquote>

		<?php
			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_lessons` WHERE `status` = 'active';");

			if(mysql_num_rows($r) < 1)
			{
				?>
		<div class="alert alert-info">В этом курсе пока нет ни одного урока</div>
				<?
			}
			else
			{
				$lessons_count = 0;
				while($lesson = mysql_fetch_array($r))
				{
					$lessons_count++;
					?>
		<div class="panel panel-info">
			<div class="panel-heading"><strong>Урок №<?php echo $lessons_count; ?></strong>: <?php echo $lesson["title"]; ?></div>
			<div class="panel-body">
				<p class="well"><?php echo $lesson["descr"]; ?></p>

				<div class="panel panel-default">
					<div class="panel-heading">Теоретические материалы</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-9">
								<?php
									$z = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_materials` WHERE `status` = 'active' AND `lesson_id` = ".$lesson["id"].";");
									if(mysql_num_rows($z) < 1)
									{
										?>
								<div class="alert alert-warning">В этом уроке пока нет теоретических материалов</div>
										<?
									}
									else
									{
										?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Название</th>
											<th>Описание</th>
											<th>Тип</th>
											<th style="width: 100px;">Действия</th>
										</tr>
									</thead>

									<tbody>
										<?php
											$materials_count = 0;
											while($material = mysql_fetch_array($z))
											{
												$materials_count++;
												?>
										<tr>
											<td><?php echo $materials_count; ?></td>
											<td><?php echo $material["title"]; ?></td>
											<td><?php echo $material["descr"]; ?></td>
											<td>
												<?php
													switch($material["type"])
													{
														case "text":
															echo "Текст лекции";
															break;

														case "document":
															echo "Документ";
															break;

														case "video":
															echo "Видео";
															break;
													}
												?>
											</td>
											<td>
												<button course-id="<?php echo $course["id"]; ?>" lesson-id="<?php echo $lesson["id"]; ?>" material-id="<?php echo $material["id"]; ?>" material-type="<?php echo $material["type"]; ?>" class="btn btn-default btn-xs viewMaterialBtn" title="Посмотреть"><span class="glyphicon glyphicon-eye-open"></span></button>
												<button course-id="<?php echo $course["id"]; ?>" lesson-id="<?php echo $lesson["id"]; ?>" material-id="<?php echo $material["id"]; ?>" material-type="<?php echo $material["type"]; ?>" class="btn btn-default btn-xs editMaterialBtn" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></button>
												<button course-id="<?php echo $course["id"]; ?>" lesson-id="<?php echo $lesson["id"]; ?>" material-id="<?php echo $material["id"]; ?>" material-type="<?php echo $material["type"]; ?>" class="btn btn-danger btn-xs deleteMaterialBtn" title="Удалить"><span class="glyphicon glyphicon-trash"></span></button>
											</td>
										</tr>
												<?
											}
										?>
									</tbody>
								</table>
										<?
									}
								?>
							</div>
							<div class="col-md-3">
								<div class="panel panel-info">
									<div class="panel-body">
										<button lesson-id="<?php echo $lesson["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-block btn-primary addMaterialTextModalBtn">Добавить текст лекции</button>
										<button lesson-id="<?php echo $lesson["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-block btn-primary addMaterialDocumentModalBtn">Добавить документ</button>
										<button lesson-id="<?php echo $lesson["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-block btn-primary addMaterialVideoModalBtn">Добавить видео</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">Тесты</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-9">
								<?php
									$z = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_tests` WHERE `status` = 'active' AND `lesson_id` = ".$lesson["id"].";");
									if(mysql_num_rows($z) < 1)
									{
										?>
								<div class="alert alert-warning">В этом уроке пока нет тестов</div>
										<?
									}
									else
									{
										?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Название</th>
											<th>Описание</th>
											<th>Количество вопросов</th>
											<th>Действия</th>
										</tr>
									</thead>

									<tbody>
										<?php
											$test_count = 0;
											while($test = mysql_fetch_array($z))
											{
												$test_count++;
												?>
										<tr>
											<td><?php echo $test_count; ?></td>
											<td><?php echo $test["title"]; ?></td>
											<td><?php echo $test["descr"]; ?></td>
											<td>
												<?php
													$qwe = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_test_".$test["id"]."_questions` WHERE `status` = 'active';");
													echo mysql_num_rows($qwe);
												?>
											</td>
											<td>
												<a href="/edit_test?id=<?php echo $test["id"]; ?>&course_id=<?php echo $course["id"]; ?>" class="btn btn-default btn-xs" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
												<button course-id="<?php echo $course["id"]; ?>" test-id="<?php echo $test["id"]; ?>" class="btn btn-danger btn-xs deleteTestBtn" title="Удалить"><span class="glyphicon glyphicon-trash"></span></button>
											</td>
										</tr>
												<?
											}
										?>
									</tbody>
								</table>
										<?
									}
								?>
							</div>
							<div class="col-md-3">
								<div class="panel panel-info">
									<div class="panel-body">
										<button lesson-id="<?php echo $lesson["id"]; ?>" course-id="<?php echo $course["id"]; ?>" class="btn btn-block btn-primary addTestModalBtn">Добавить новый тест</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<button course-id="<?php echo $course["id"]; ?>" lesson-id="<?php echo $lesson["id"]; ?>" class="btn btn-default editLessonBtn">Редактировать</button>
				<button course-id="<?php echo $course["id"]; ?>" lesson-id="<?php echo $lesson["id"]; ?>" class="btn btn-danger deleteLessonBtn">Удалить</button>

			</div>
		</div>

					<?
				}
			}
		?>
	</div>
</div>
		<?
	}