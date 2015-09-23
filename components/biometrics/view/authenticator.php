<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Идентификация</h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <form action="">
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert">Вводите в поля слова, указанные слева от них. Старайтесь не делать ошибок. После ввода слова в поле нажимайте клавишу <kbd>Enter</kbd>. Повторяйте ввод слов до тех пор, пока индикатор наполнения под соответствующим полем не заполнится. После этого соответствующее поле ввода будет выключено.</div>
                        </div>

                        <!-- secret-code block -->
                        <div class="panel panel-info">
                            <div class="panel-heading">Логин</div>
                            <div class="panel-body">
                                <div class="form-group hidden">
                                    <input type="text" id="courseId" class="hidden" value="<?php echo $_POST['courseId']?>">
                                    <input type="text" id="testId" class="hidden" value="<?php echo $_POST['testId']?>">
                                    <input type="text" id="userId" class="hidden" value="<?php echo $_POST['userId']?>">
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="secretCode-phrase"></div>
                                        <input type="text" class="form-control" id="secretCode" placeholder="Логин" autocomplete="off" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="progress">
                                        <div id="secretCode-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End of login block -->
                    </form>  
                </div>    
            </div>
        </div>
    </div>

    <div class="modal-footer" id="button">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary" id="send_data">Отправить</button>
    </div>
</div><!-- /.modal-content -->