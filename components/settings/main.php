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
		<blockquote>Название, отображаемое в заголовке окна и шапке сайта</blockquote>
		<form class="form-inline">
			<div class="form-group">
				<input type="text" class="form-control" value="<?php echo $site_title; ?>" id="settingsTitle">
			</div>
			<div class="form-group" id="settingsTitleHelper">
			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Тип регистрации</blockquote>
		<form class="form-inline">
			<div class="form-group">
				<select class="form-control" id="settingsReg">
					<option value="true"<?php if($free_register=="true") echo " selected"; ?>>Любой может зарегистрироваться</option>
					<option value="false"<?php if($free_register=="false") echo " selected"; ?>>Пользователей создаёт администратор</option>
				</select>
			</div>
			<div class="form-group" id="settingsRegHelper">
			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Роль по умолчанию для зарегистрировавшегося пользователя</blockquote>
		<form class="form-inline">
			<div class="form-group">
				<select class="form-control" id="settingsRole">
					<option value="student"<?php if($reg_role=="student") echo " selected"; ?>>Студент</option>
					<option value="teacher"<?php if($reg_role=="teacher") echo " selected"; ?>>Преподаватель</option>
				</select>
			</div>
			<div class="form-group" id="settingsRoleHelper">
			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Редактирование своих данных для пользователей с ролью Студент</blockquote>
		<form class="form-inline">
			<div class="form-group">
				<select class="form-control" id="settingsEdit">
					<option value="false"<?php if($student_edit=="false") echo " selected"; ?>>Запретить</option>
					<option value="true"<?php if($student_edit=="true") echo " selected"; ?>>Разрешить</option>
				</select>
			</div>
			<div class="form-group" id="settingsEditHelper">
			</div>
		</form>
	</div>
</div>
<?php
	}
?>