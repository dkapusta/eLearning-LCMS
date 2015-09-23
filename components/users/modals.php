<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Редактирование пользователя</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">

					<div class="form-group">
						<label for="userEdEmail" class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="userEdEmail" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="userEdPass" class="col-sm-3 control-label">Новый пароль</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="userEdPass" placeholder="Оставьте пустым, чтобы не менять">
						</div>
					</div>
					<div class="form-group">
						<label for="userEdFirstName" class="col-sm-3 control-label">Имя</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="userEdFirstName" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="userEdLastName" class="col-sm-3 control-label">Фамилия</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="userEdLastName" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="userEdRole" class="col-sm-3 control-label">Роль</label>
						<div class="col-sm-9">
							<select class="form-control" id="userEdRole">
								<option value="1">Ученик</option>
								<option value="2">Учитель</option>
								<option value="3">Администратор</option>
							</select>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button id="saveUserBtn" type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>