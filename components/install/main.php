<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>eLearn LMS | Установка</title>
	<link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/css/elearn.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				&nbsp;
				<div class="panel panel-primary">
					<div class="panel-heading">Установка eLearn LMS</div>
					<div class="panel-body">
						<form class="form-horizontal" method="post" action="/?act=install" id="installForm">
							<blockquote>
								Данные для подключения к БД
							</blockquote>

							<div class="form-group">
    							<label for="dbHost" class="col-sm-3 control-label">Имя хоста</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="dbHost" name="dbHost" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="dbUser" class="col-sm-3 control-label">Пользователь</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="dbUser" name="dbUser" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="dbPass" class="col-sm-3 control-label">Пароль</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="dbPass" name="dbPass" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="dbName" class="col-sm-3 control-label">Название БД</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="dbName" name="dbName" placeholder="">
    							</div>
  							</div>

  							<blockquote>
								Данные администратора
							</blockquote>

							<div class="form-group">
    							<label for="adminLogin" class="col-sm-3 control-label">Логин</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="adminLogin" name="adminLogin" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="adminEmail" class="col-sm-3 control-label">E-mail</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="adminEmail" name="adminEmail" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="adminPass" class="col-sm-3 control-label">Пароль</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="adminPass" name="adminPass" placeholder="">
    							</div>
  							</div>
                <div class="form-group">
                  <label for="adminControl" class="col-sm-3 control-label">Контрольное слово (мин. 12 символов)</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="adminControl" name="adminControl" placeholder="">
                  </div>
                </div>

  							<blockquote>
								Дополнительно
							</blockquote>

							<div class="form-group">
    							<label for="siteName" class="col-sm-3 control-label">Название сайта</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="siteName" name="siteName" placeholder="">
    							</div>
  							</div>
  							<div class="form-group">
    							<label for="dbPref" class="col-sm-3 control-label">Префикс таблиц БД</label>
    							<div class="col-sm-9">
      								<input type="text" class="form-control" id="dbPref" name="dbPref" placeholder="">
    							</div>
  							</div>

  							<div class="form-group">
    							<div class="col-sm-offset-3 col-sm-9">
     	 							<button type="button" class="btn btn-primary" disabled="disabled" id="installLMS">Установить</button>
     	 							<button type="button" class="btn btn-default" id="checkDBInfo">Проверить данные для подключения к БД</button>
    							</div>
  							</div>
						</form>
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