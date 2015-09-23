<?php
	if($user["role"] < 3)
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
		<blockquote>Добавить новую категорию</blockquote>
		<form class="form-horizontal">
			<div class="form-group">
    			<label for="categoryTitle" class="col-sm-2 control-label">Название</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="categoryTitle" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="categoryDescr" class="col-sm-2 control-label">Описание</label>
    			<div class="col-sm-10">
      				<textarea class="form-control" id="categoryDescr" rows="3"></textarea>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-2 col-sm-10">
      				<button type="button" class="btn btn-default" id="newCategoryBtn">Создать</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Категории курсов</blockquote>
<?php 
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `status` = 'active';");
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
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `status` = 'active';");
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
						<button class="btn btn-default btn-xs catEditBtn" type="button" category-id="<?php echo $data["id"]; ?>"><span class="glyphicon glyphicon-edit"></span></button>
						<button class="btn btn-danger btn-xs catDeleteBtn" type="button" category-id="<?php echo $data["id"]; ?>"><span class="glyphicon glyphicon-trash"></span></button>
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
		<div class="alert alert-info">Ни одной категории пока не создано</div>
<?
	}
?>
	</div>
</div>
<?php
	}
?>