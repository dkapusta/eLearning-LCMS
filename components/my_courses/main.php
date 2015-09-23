<?php
	if($user["role"] < 2)
	{
?>
<div class="panel panel-danger">
	<div class="panel-heading">
		У Вас не достаточно прав для просмотра этой страницы
	</div>
</div>
<?
	}
	else
	{
?>
<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Создать новый курс</blockquote>
		<form class="form-horizontal">
			<div class="form-group">
    			<label for="courseTitle" class="col-sm-2 control-label">Название</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="courseTitle" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="courseDescr" class="col-sm-2 control-label">Описание</label>
    			<div class="col-sm-10">
      				<textarea class="form-control" id="courseDescr" rows="3"></textarea>
    			</div>
  			</div>
  			<div class="form-group">
  				<label for="coursePrivacy" class="col-sm-2 control-label">Дополнительно</label>
    			<div class="col-sm-10">
      				<select class="form-control" id="coursePrivacy">
      					<option value="everyone">Разрешать пересдачу</option>
      					<option value="protected">Не разрешать пересдачу</option>
      				</select>
    			</div>
  			</div>
  			<div class="form-group">
  				<label for="courseSecure" class="col-sm-2 control-label">Безопасность</label>
    			<div class="col-sm-10">
      				<select class="form-control" id="courseSecure">
      					<option value="0">Не использовать биотметрическую аутентификацию</option>
      					<option value="1">Использовать биотметрическую аутентификацию</option>
      				</select>
      				&nbsp;
      				<input type="text" id="courseLimit" class="form-control" placeholder="Порог прохождения аутентификации">
    			</div>
  			</div>
  			<div class="form-group">
  				<label for="courseCategory" class="col-sm-2 control-label">Категория</label>
    			<div class="col-sm-10">
      				<select class="form-control" id="courseCategory">
      					<option value="0">Без категории</option>
      					<?php
      						$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `status` = 'active';");
      						while($data = mysql_fetch_object($r))
      						{
      							?>
      					<option value="<?php echo $data->id; ?>"><?php echo $data->title; ?></option>
      							<?
      						}
      					?>
      				</select>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="button" class="btn btn-default" id="newCourseBtn">Создать</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Управление моими курсами</blockquote>
<?php 
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `status` = 'active' AND `author` = ".$user["id"].";");

	if(mysql_num_rows($r) > 0)
	{
?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Название</th>
					<th>Описание</th>
					<th>Действия</th>
				</tr>
			</thead>

			<tbody>
<?php
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `status` = 'active' AND `author` = ".$user["id"].";");
	$count = 0;
	while($data = mysql_fetch_array($r))
	{
		$count++;
?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $data["title"]; ?></td>
					<td><?php echo $data["descr"]; ?></td>
					<td>
						<button class="btn btn-default btn-xs courseEditBtn" type="button" course-id="<?php echo $data["id"]; ?>"><span class="glyphicon glyphicon-edit"></span></button>
						<button class="btn btn-danger btn-xs courseDeleteBtn" type="button" course-id="<?php echo $data["id"]; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
		<div class="alert alert-info">Вами пока не создано ни одного курса</div>
<?
	}
?>
	</div>
</div>
<?php
	}
?>