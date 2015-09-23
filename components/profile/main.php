<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Информация о пользователе</blockquote>

		<div class="panel panel-info">
			<div class="panel-body"><?php echo $user["login"]; ?></div>
			<div class="panel-footer">Логин</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-body"><?php echo $user["email"]; ?></div>
			<div class="panel-footer">E-mail</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-body">
				<?php 
					if($user["role"]=="3")
					{
						echo "Администратор";
					} 
					else if($user["role"]=="2")
					{
						echo "Учитель";
					}
					else
					{
						echo "Ученик";
					}
				?>
			</div>
			<div class="panel-footer">Роль</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-body"><?php echo $user["first_name"]." ".$user["last_name"]; ?></div>
			<div class="panel-footer">Имя и фамилия</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-body"><?php echo $user["secret_code"]; ?></div>
			<div class="panel-footer">Контрольное слово</div>
		</div>
	</div>
</div>