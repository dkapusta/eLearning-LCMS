<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>eLearn LMS | Вход</title>
	<link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/css/elearn.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				&nbsp;
				<div class="panel panel-primary">
					<div class="panel-heading">Требуется авторизация</div>
					<div class="panel-body">
						<blockquote>
							Войдите на сайт
						</blockquote>

						<form class="form-horizontal">
							<div class="form-group">
    							<label for="authLogin" class="col-sm-3 control-label">Логин</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="authLogin" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="authPass" class="col-sm-3 control-label">Пароль</label>
    							<div class="col-sm-9">
      								<input type="password" class="form-control" id="authPass" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<div class="col-sm-offset-3 col-sm-9">
      								<button type="button" class="btn btn-primary" id="doAuth">Войти</button>
    							</div>
  							</div>
						</form>

						<?php
							$r = mysql_query("SELECT * FROM `".$config["dbPref"]."config` WHERE `key` = 'free_register';");
							$data = mysql_fetch_array($r);

							if($data["value"] == "true")
							{
								?>
						<blockquote>
							Нет аккаунта? Зарегистрируйтесь!
						</blockquote>

						<form class="form-horizontal">
							<div class="form-group">
    							<label for="regLogin" class="col-sm-3 control-label">Логин</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="regLogin" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="regEmail" class="col-sm-3 control-label">E-mail</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="regEmail" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="regPass" class="col-sm-3 control-label">Пароль</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="regPass" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="regControl" class="col-sm-3 control-label">Контрольное слово (мин. 12 символов)</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="regControl" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<div class="col-sm-offset-3 col-sm-9">
      								<button type="button" class="btn btn-primary" id="doReg">Зарегистрироваться</button>
    							</div>
  							</div>
						</form>
								<?
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="/js/jquery.js" language="javascript"></script>
	<script src="/js/bootstrap.js" language="javascript"></script>
	<script src="/js/elearn.js" language="javascript"></script>
</body>
</html>