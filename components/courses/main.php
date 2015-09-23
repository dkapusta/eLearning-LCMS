<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Фильтр</blockquote>
		<form class="form-horizontal">
			<div class="form-group">
				<label for="courseCategory" class="col-sm-2 control-label">Категория</label>
				<div class="col-sm-10">
					<select class="form-control" id="filterCategory">
						<option value="none">Любая категория</option>
						<option value="0"<?php if(isset($_GET["categoryId"]) && $_GET["categoryId"]==0) echo " selected"; ?>>Без категории</option>
						<?php
							$r = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `status` = 'active';");
							while($data = mysql_fetch_object($r))
							{
								?>
						<option value="<?php echo $data->id; ?>"<?php if($data->id == $_GET["categoryId"]) echo " selected"; ?>><?php echo $data->title; ?></option>
								<?
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-default" id="applyFilterBtn">Искать</button>
					</div>
				</div>
		</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<blockquote>Результаты поиска</blockquote>

<?php
	$cat = $_GET["categoryId"];
	$cat = $cat=="" ? "" : " AND `category` = ".$cat;
	$r = mysql_query("SELECT * FROM `".$config["dbPref"]."courses` WHERE `status` = 'active'".$cat." ORDER BY `id` DESC;");

	if(mysql_num_rows($r) < 1)
	{
?>
		<div class="alert alert-info">По Вашему запросу не найдено ни одного курса</div>
<?php
	}
	else
	{
?>
		<div class="row">
		<?php
				while($course = mysql_fetch_array($r))
				{
		?>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><?php echo $course["title"]; ?></div>
					<div class="panel-body">
						<div class="well"><?php echo $course["descr"]; ?></div>

						<?php 
							$cat = $course["category"]; 
							if($cat==0)
							{
								$cat = "Без категории";
							}
							else
							{
								$z = mysql_query("SELECT * FROM `".$config["dbPref"]."categories` WHERE `id` = ".$cat.";");
								$catname = mysql_fetch_array($z);
								$cat = $catname["title"];
							}
						?>

						<div class="row">
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body text-center">
										<a href="/courses?categoryId=<?php echo $course["category"]; ?>"><?php echo $cat; ?></a>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body text-center">
										<?php
											$u = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_users`;");
											$count = mysql_num_rows($u);

											$s = mysql_query("SELECT * FROM `".$config["dbPref"]."course_".$course["id"]."_users` WHERE `user_id` = ".$user["id"].";");
											$you = mysql_num_rows($s);
										?>
										<span class="glyphicon glyphicon-user"></span> 
										<?php echo $count; ?> 
										<?php
											if($you > 0)
											{
												echo "(включая Вас)";
											}
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body text-center">
										<?php
											$au = mysql_query("SELECT * FROM `".$config["dbPref"]."users` WHERE `id` = ".$course["author"].";");
											$author = mysql_fetch_array($au);

											echo "Автор: <span class='text-muted'>";
											
											if($author["first_name"] || $author["last_name"])
											{
												echo $author["first_name"]." ".$author["last_name"];
											}
											else
											{
												echo $author["login"];
											}
											echo "</span>";
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer text-center">
						<a href="/course/<?php echo $course["id"]; ?>" class="btn btn-default">Открыть</a>
					</div>
				</div>
			</div>
					<?
				}
			?>
		</div>
<?php
	}
?>
	</div>
</div>