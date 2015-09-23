<div class="modal fade" id="editLessonModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Редактирование урока</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="lessonEdTitle" class="col-sm-2 control-label">Название</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="lessonEdTitle">
						</div>
					</div>
					<div class="form-group">
						<label for="lessonEdDescr" class="col-sm-2 control-label">Описание</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="lessonEdDescr" rows="3"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="saveLessonBtn" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewLessonMaterialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content panel panel-default">
			<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title" id="viewLessonMaterialTitle"></span>
			</div>
			<div class="modal-body panel-body" id="viewLessonMaterialContent"></div>
			<div class="modal-footer panel-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="viewMaterialBtnClose">Закрыть</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addLessonMaterialTextModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Добавление текста лекции</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
    					<label for="textMaterialTitle">Название</label>
    					<input type="text" class="form-control" id="textMaterialTitle">
  					</div>
  					<div class="form-group">
    					<label for="textMaterialDescr">Описание</label>
    					<textarea class="form-control" id="textMaterialDescr" rows="3"></textarea>
  					</div>
  					<div class="form-group">
    					<textarea class="form-control tinymce" id="textMaterialContent" rows="30"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="addMaterialTextBtn" class="btn btn-primary">Добавить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addLessonMaterialDocumentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Добавление документа</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="alert alert-info">
						Здесь Вы можете добавить в курс документ или презентацию из Google Docs или Slideshare.
					</div>
					<div class="form-group">
    					<label for="documentMaterialTitle">Название</label>
    					<input type="text" class="form-control" id="documentMaterialTitle">
  					</div>
  					<div class="form-group">
    					<label for="documentMaterialDescr">Описание</label>
    					<textarea class="form-control" id="documentMaterialDescr" rows="3"></textarea>
  					</div>
  					<div class="form-group">
  						<label for="documentMaterialDescr">Код для вставки</label>
    					<textarea class="form-control" id="documentMaterialContent" rows="5" placeholder="<iframe src='...'></iframe>"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="addMaterialDocumentBtn" class="btn btn-primary">Добавить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addLessonMaterialVideoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Добавление видео</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="alert alert-info">
						Здесь Вы можете добавить в курс видео из YouTube или другого видео-сервиса.
					</div>
					<div class="form-group">
    					<label for="videoMaterialTitle">Название</label>
    					<input type="text" class="form-control" id="videoMaterialTitle">
  					</div>
  					<div class="form-group">
    					<label for="videoMaterialDescr">Описание</label>
    					<textarea class="form-control" id="videoMaterialDescr" rows="3"></textarea>
  					</div>
  					<div class="form-group">
  						<label for="videoMaterialDescr">Код для вставки</label>
    					<textarea class="form-control" id="videoMaterialContent" rows="5" placeholder="<iframe src='...'></iframe>"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="addMaterialVideoBtn" class="btn btn-primary">Добавить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editLessonMaterialEmbedModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Редактирование</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
    					<label for="embedMaterialTitle">Название</label>
    					<input type="text" class="form-control" id="embedMaterialTitle">
  					</div>
  					<div class="form-group">
    					<label for="embedMaterialDescr">Описание</label>
    					<textarea class="form-control" id="embedMaterialDescr" rows="3"></textarea>
  					</div>
  					<div class="form-group">
  						<label for="embedMaterialDescr">Код для вставки</label>
    					<textarea class="form-control" id="embedMaterialContent" rows="5" placeholder="<iframe src='...'></iframe>"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="saveMaterialEmbedBtn" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editLessonMaterialTextModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Редактирование</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
    					<label for="textMaterialEdTitle">Название</label>
    					<input type="text" class="form-control" id="textMaterialEdTitle">
  					</div>
  					<div class="form-group">
    					<label for="textMaterialEdDescr">Описание</label>
    					<textarea class="form-control" id="textMaterialEdDescr" rows="3"></textarea>
  					</div>
  					<div class="form-group">
    					<textarea class="form-control tinymce" id="textMaterialEdContent" rows="30"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="saveMaterialTextBtn" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Создать тест</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
    					<label for="testTitle">Название</label>
    					<input type="text" class="form-control" id="testTitle">
  					</div>
  					<div class="form-group">
    					<label for="testDescr">Описание</label>
    					<textarea class="form-control" id="testDescr" rows="3"></textarea>
  					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" id="addTestBtn" class="btn btn-primary">Создать</button>
			</div>
		</div>
	</div>
</div>