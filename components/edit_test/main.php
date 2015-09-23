<?php
	$test_id = $_GET["id"];
	$course_id = $_GET["course_id"];

	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `id` = ".$course_id.";");
	$course = mysql_fetch_array($r);

	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course_id."_tests` WHERE `id` = ".$test_id.";");
	$test = mysql_fetch_array($r);

	if($user["id"] != $course["author"])
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
		<a href="/edit_course?id=<?php echo $course_id; ?>" class="btn btn-primary">Назад к редактированию курса</a>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Редактировать тест</blockquote>

		<form class="form-horizontal">
			<div class="form-group">
    			<label for="testTitle" class="col-sm-2 control-label">Название</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="testTitle" placeholder="" value="<?php echo htmlspecialchars_decode($test["title"]) ?>">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="testDescr" class="col-sm-2 control-label">Описание</label>
    			<div class="col-sm-10">
      				<textarea class="form-control" id="testDescr" rows="3"><?php echo htmlspecialchars_decode($test["descr"]) ?></textarea>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="button" class="btn btn-default" id="saveTestBtn" course-id="<?php echo $course["id"]; ?>" test-id="<?php echo $test["id"]; ?>">Сохранить</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">Вопросы теста</div>

	<div class="panel-body">
		<div class="panel panel-info">
			<div class="panel-body">
				<blockquote>Добавить вопрос</blockquote>

				<form>
					<div class="form-group">
      					<textarea class="form-control" id="questionText" placeholder="Текст вопроса"></textarea>
  					</div>
  					<div class="form-group">
    					<label for="questionType">Тип вопроса</label>
    					<select class="form-control" id="questionType">
    						<option value="select">Вопрос с выбором ответа</option>
    						<option value="enter">Вопрос со вводом ответа</option>
    					</select>
  					</div>
  					<div class="alert alert-info">Следующие четыре поля игнорируются в случае, если это вопрос с ручным вводом ответа</div>
  					<div class="form-group">
  						<div class="row">
  							<div class="col-md-6">
  								<input type="text" id="questionVar1" class="form-control" placeholder="Вариант 1">
  							</div>
  							<div class="col-md-6">
  								<input type="text" id="questionVar2" class="form-control" placeholder="Вариант 2">
  							</div>
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="row">
  							<div class="col-md-6">
  								<input type="text" id="questionVar3" class="form-control" placeholder="Вариант 3">
  							</div>
  							<div class="col-md-6">
  								<input type="text" id="questionVar4" class="form-control" placeholder="Вариант 4">
  							</div>
  						</div>
  					</div>
  					<div class="form-group">
  						<label for="questionAnswer">Ответ</label>
  						<input type="text" id="questionAnswer" class="form-control" placeholder="Слово, фраза или номер правильного варианта ответа (число)">
  					</div>

  					<div class="form-group">
      					<button type="button" class="btn btn-primary" id="addQuestionBtn" course-id="<?php echo $course["id"]; ?>" test-id="<?php echo $test["id"]; ?>">Добавить</button>
  					</div>
				</form>
			</div>
		</div>

		<?php
			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_test_".$test["id"]."_questions` WHERE `status` = 'active';");
			if(mysql_num_rows($r) < 1)
			{
				?>
		<div class="alert alert-warning">В этом тесте нет ни одного вопроса</div>
				<?
			}
			else
			{
				$questions_count = 0;
				while($question = mysql_fetch_array($r))
				{
					$questions_count++;
					?>
		<div class="panel panel-primary">
			<div class="panel-heading">Вопрос №<?php echo $questions_count; ?></div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-9">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php echo $question["question"]; ?>
							</div>
						</div>

						<div class="row"<?php if($question["type"]=="enter") echo " style='display: none;';"; ?>>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body"><?php echo $question["var1"]; ?></div>
									<div class="panel-footer">Вариант 1</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body"><?php echo $question["var2"]; ?></div>
									<div class="panel-footer">Вариант 2</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body"><?php echo $question["var3"]; ?></div>
									<div class="panel-footer">Вариант 3</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body"><?php echo $question["var4"]; ?></div>
									<div class="panel-footer">Вариант 4</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="panel panel-success">
							<div class="panel-heading">Правильный ответ</div>
							<div class="panel-body"><?php echo $question["answer"]; ?></div>
						</div>
					</div>
				</div>

				<hr/>

				<div class="row">
					<div class="col-md-12">
						<button course-id="<?php echo $course["id"]; ?>" test-id="<?php echo $test["id"]; ?>" question-id="<?php echo $question["id"]; ?>" class="btn btn-default editQuestionBtn">Редактировать</button>
						<button course-id="<?php echo $course["id"]; ?>" test-id="<?php echo $test["id"]; ?>" question-id="<?php echo $question["id"]; ?>" class="btn btn-danger deleteQuestionBtn">Удалить</button>
					</div>
				</div>
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