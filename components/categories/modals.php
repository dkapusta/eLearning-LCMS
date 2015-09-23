<div class="modal fade" id="editCatModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Редактирование категории</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <input type="hidden" id="editCat_id">

          <div class="form-group">
            <label for="editCat_title" class="col-sm-2 control-label">Название</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="editCat_title">
            </div>
          </div>
          <div class="form-group">
            <label for="editCat_descr" class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
              <textarea rows="3" class="form-control" id="editCat_descr"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary" id="editCat_saveBtn">Сохранить</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteCatModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удаление категории</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="delCat_id">
        Вы правда хотите удалить категорию "<span id="delCat_title"></span>"?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-danger" id="delCat_btn">Удалить</button>
      </div>
    </div>
  </div>
</div>