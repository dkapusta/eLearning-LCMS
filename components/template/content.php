	<div class="navbar navbar-default navbar-static-top">
		<div class="container-fluid">
			<a class="navbar-brand" href="/"><?php echo $site_title; ?></a>

			<ul class="nav navbar-nav">
				<li<?php if($com[0]=="courses") echo " class='active'"; ?>><a href="/courses"><span class="glyphicon glyphicon-tasks"></span> Курсы</a></li>
			</ul>

			<button type="button" class="btn btn-default navbar-btn pull-right" id="logoutBtn">Выйти</button>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked">
<?php
	if($user["role"] > 2)
	{
?>
							<h5><span class="text-muted">Администрирование</span></h5>
							<li<?php if($com[0]=="settings") echo " class='active'"; ?>><a href="/settings"><span class="glyphicon glyphicon-cog"></span> Настройки сайта</a></li>
							<li<?php if($com[0]=="categories") echo " class='active'"; ?>><a href="/categories"><span class="glyphicon glyphicon-list"></span> Категории курсов</a></li>
							<li<?php if($com[0]=="users") echo " class='active'"; ?>><a href="/users"><span class="glyphicon glyphicon-user"></span> Пользователи</a></li>
<?php
	}
?>

							<h5><span class="text-muted">Аккаунт</span></h5>
							<li<?php if($com[0]=="profile") echo " class='active'"; ?>><a href="/"><span class="glyphicon glyphicon-home"></span> Информация</a></li>
<?php
	if($student_edit == "true" || $user["role"] > 1)
	{
?>
							<li<?php if($com[0]=="edit") echo " class='active'"; ?>><a href="/edit"><span class="glyphicon glyphicon-edit"></span> Редактировать</a></li>
<?php
	}
?>

							<h5><span class="text-muted">Обучение</span></h5>
							<li<?php if($com[0]=="progress") echo " class='active'"; ?>><a href="/progress"><span class="glyphicon glyphicon-education"></span> Мой прогресс</a></li>

<?php
	if($user["role"] > 1)
	{
?>
							<h5><span class="text-muted">Преподавание</span></h5>
							<li<?php if($com[0]=="my_courses") echo " class='active'"; ?>><a href="/my_courses"><span class="glyphicon glyphicon-list-alt"></span> Мои курсы</a></li>
							<li<?php if($com[0]=="/marks") echo " class='active'"; ?>><a href="/marks"><span class="glyphicon glyphicon-th-list"></span> Результаты</a></li>
<?php
	}
?>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-9">
