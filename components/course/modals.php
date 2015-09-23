<div class="modal fade" id="applyForCourseModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="applyForCourseContent">
  </div>
</div>

<div class="modal fade" id="applyForTestModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="applyForTestContent">
  </div>
</div>

<div class="modal fade" id="captchaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" id="captchaContent">
    </div>
</div>

<div class="modal fade" id="viewMaterialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content panel panel-default">
			<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title" id="viewMaterialTitle"></span>
			</div>
			<div class="modal-body panel-body" id="viewMaterialContent"></div>
			<div class="modal-footer panel-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="viewMaterialBtn2Close">Закрыть</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="passTestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="passTestLabel">Тест</h4>
      		</div>
      		<div class="modal-body" id="testModalContent">
        		<div class="row">
        			<div class="col-md-8">
        				<div class="panel panel-default">
        					<div class="panel-heading" id="testTitle"></div>
        					<div class="panel-body" id="testQuestion"></div>
        				</div>

        				<div class="row" id="testVariants">
        					<div class="col-md-6">
        						<div class="panel panel-default">
        							<div class="panel-body text-center" id="testVar1">1</div>
        							<div class="panel-footer text-center">
        								<input type="radio" value="1" name="testAnswer" class="testAnswer">
        							</div>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<div class="panel panel-default">
        							<div class="panel-body text-center" id="testVar2">1</div>
        							<div class="panel-footer text-center">
        								<input type="radio" value="2" name="testAnswer" class="testAnswer">
        							</div>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<div class="panel panel-default">
        							<div class="panel-body text-center" id="testVar3">1</div>
        							<div class="panel-footer text-center">
        								<input type="radio" value="3" name="testAnswer" class="testAnswer">
        							</div>
        						</div>
        					</div>
        					<div class="col-md-6">
        						<div class="panel panel-default">
        							<div class="panel-body text-center" id="testVar4">1</div>
        							<div class="panel-footer text-center">
        								<input type="radio" value="4" name="testAnswer" class="testAnswer">
        							</div>
        						</div>
        					</div>
        				</div>

        				<div class="row" id="testAnswerInput">
        					<div class="col-md-12">
        						<div class="panel panel-default">
        							<div class="panel-body">
        								<input type="text" id="testAnswerEnter" class="form-control">
        							</div>
        							<div class="panel-footer">Введите сюда Ваш ответ</div>
        						</div>
        					</div>
        				</div>
        			</div>

        			<div class="col-md-4">
        				<div class="panel panel-info">
        					<div class="panel-body">
        						<button id="saveAnswerBtn" class="btn btn-default btn-block">Сохранить ответ</button>
        						<button id="checkTestBtn" class="btn btn-primary btn-block">Проверить</button>

        						<hr/>

        						<div class="well" id="testNavigation" style="line-height: 2.5;"></div>
        					</div>
        				</div>
        			</div>
        		</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      		</div>
    	</div>
	</div>
</div>