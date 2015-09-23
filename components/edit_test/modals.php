<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Редактировать вопрос</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="questionEdText" class="col-sm-3 control-label">Текст вопроса</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="questionEdText"></textarea>
						</div>
					</div>
					<div class="form-group" id="blockVar1">
						<label for="questionEdVar1" class="col-sm-3 control-label">Вариант 1</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="questionEdVar1">
						</div>
					</div>
					<div class="form-group" id="blockVar2">
						<label for="questionEdVar2" class="col-sm-3 control-label">Вариант 2</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="questionEdVar2">
						</div>
					</div>
					<div class="form-group" id="blockVar3">	
						<label for="questionEdVar3" class="col-sm-3 control-label">Вариант 3</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="questionEdVar3">
						</div>
					</div>
					<div class="form-group" id="blockVar4">
						<label for="questionEdVar4" class="col-sm-3 control-label">Вариант 4</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="questionEdVar4">
						</div>
					</div>
					<div class="form-group">
						<label for="questionEdAnswer" class="col-sm-3 control-label">Ответ</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="questionEdAnswer">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button id="saveQuestionBtn" type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>