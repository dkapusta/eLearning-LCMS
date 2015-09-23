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
		<blockquote>Новый пользователь</blockquote>

		<form class="form-horizontal">
			<div class="form-group">
    			<label for="userLogin" class="col-sm-3 control-label">Логин</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userLogin" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userEmail" class="col-sm-3 control-label">E-mail</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userEmail" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userPass" class="col-sm-3 control-label">Пароль</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userPass" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userControl" class="col-sm-3 control-label">Контрольное слово (мин. 12 символов)</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userControl" placeholder="">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userFirstName" class="col-sm-3 control-label">Информация</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userFirstName" placeholder="Имя">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userLastName" class="col-sm-3 control-label">&nbsp;</label>
    			<div class="col-sm-9">
      				<input type="text" class="form-control" id="userLastName" placeholder="Фамилия">
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="userRole" class="col-sm-3 control-label">Роль</label>
    			<div class="col-sm-9">
      				<select id="userRole" class="form-control">
      					<option value="1">Ученик</option>
      					<option value="2">Учитель</option>
      					<option value="3">Администратор</option>
      				</select>
    			</div>
  			</div>
			<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-9">
      				<button type="button" class="btn btn-default" id="newUserBtn">Создать</button>
    			</div>
  			</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Список пользователей</blockquote>

		<?php
			$r = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` > 1 AND `id` <> ".$user["id"]." AND `status` = 'active';");

			if(mysql_num_rows($r) < 1)
			{
				?>
		<div class="alert alert-info">В системе нет пользователей, кроме текущего пользователя и главного администратора</div>
				<?
			}
			else
			{
				?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Логин</th>
					<th>E-mail</th>
					<th>Роль</th>
					<th>Имя</th>
					<th>Фамилия</th>
					<th>Действия</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$count = 0;
					while($data = mysql_fetch_array($r))
					{
						$count++;
						?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $data["login"]; ?></td>
					<td><?php echo $data["email"]; ?></td>
					<td>
						<?php 
							$role = $data["role"]; 
							if($role == 1)
							{
								echo "Ученик";
							}
							else if($role == 2)
							{
								echo "Учитель";
							}
							else
							{
								echo "Администратор";
							}
						?>
					</td>
					<td><?php echo $data["first_name"]; ?></td>
					<td><?php echo $data["last_name"]; ?></td>
					<td>
						<button user-id="<?php echo $data["id"]; ?>" class="btn btn-default btn-xs userEditBtn" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></button>
						<button user-id="<?php echo $data["id"]; ?>" class="btn btn-danger btn-xs userDeleteBtn" title="Удалить"><span class="glyphicon glyphicon-trash"></span></button>
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
</div>
		<?
	}