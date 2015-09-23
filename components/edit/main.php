<?php
	if($user["role"]<2 && $student_edit!="true")
	{
		?>
<div class="alert alert-danger">У Вас не достаточно прав для просмотра этой страницы</div>
		<?
	}
	else
	{
		?>
<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Редактировать свои данные</blockquote>

		<form class="form-horizontal">
			<div class="form-group">
    			<label for="userFirstName" class="col-sm-3 control-label">Имя</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userFirstName" value="<?php echo $user["first_name"]; ?>">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userLastName" class="col-sm-3 control-label">Фамилия</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userLastName" value="<?php echo $user["last_name"]; ?>">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userPass" class="col-sm-3 control-label">Новый пароль</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userPass" placeholder="Оставьте пустым, если не хотите менять">
    			</div>
  			</div>
  			<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-9">
      				<button id="saveUserData" class="btn btn-default">Сохранить</button>
    			</div>
  			</div>
		</form>
	</div>
</div>
		<?
	}