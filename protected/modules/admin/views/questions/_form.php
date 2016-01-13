<div class="row add-edit-question-form">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'questions-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),	
		)); 
		$display = 'none';
		if(!empty($model->qt_type)){
			if($model->qt_type==2){
				$display = 'block';	
			}
		}
		?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php 
			$types = array(1 => 'Text', 2 => 'Text and Image');
			echo $form->dropDownListRow($model,'qt_type',$types,array('class'=>'form-control')); 
			?>
			<?php 
			$examsData = Exams::model()->findAll();
			$exams = CHtml::listData($examsData,'ex_id','ex_title');
			echo $form->dropDownListRow($model,'qt_exam_id',$exams,array('class'=>'form-control','empty' => 'Select Exam')); 
			?>
			<?php echo $form->textFieldRow($model,'qt_name',array('class'=>'form-control','maxlength'=>255)); ?>
			<?php echo $form->textAreaRow($model,'qt_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->textFieldRow($model,'qt_marks',array('class'=>'form-control','value' => (!empty($model->qt_marks)) ? $model->qt_marks : 1)); ?>
			<div style="display:<?php echo $display; ?>;">
				<?php 
				echo $form->fileFieldRow($model,'qt_image',array('class'=>'form-control')); 
				?>
				<div style="clear:both;">&nbsp;</div>
				<?php
				if(!empty($model->qt_image)){
					?>
					<img src="<?php echo Yii::app()->baseUrl; ?>/storage/questions/<?php echo $model->qt_image; ?>" width="100">
					<?php
				}
				?>
			</div>
        	<div class="clear">&nbsp;</div>
			<div>
				<label>Add options</label>
			</div>
			<div class="question_options">
				<?php
				if(!empty($model->qoptQat)){
					foreach ($model->qoptQat as $optKey => $optArr) {
						?>
						<div class="col-md-12">
							<div class="col-md-10">
								<div class="col-md-8">
									<div>
										<input type="text" placeholder="Option 1" name="qoptions[]" value="<?php echo $optArr->qto_name; ?>">
									</div>
									<div class="image" style="display: <?php echo $display; ?>;">
										<input type="file" name="qfile[]">
										<input type="hidden" name="image_name[]" value="<?php echo $optArr->qto_image; ?>">
									</div>
									<?php 
									if(!empty($optArr->qto_image)){ 
										?>
										<div style="display: <?php echo $display; ?>" class="viewimage">
											<img src="<?php echo Yii::app()->baseUrl; ?>/storage/qoptions/<?php echo $optArr->qto_image; ?>" height="100">
										</div>
										<?php 
									} 
									?>
								</div>
								<div class="col-md-4" align="center">
									Right Ans<br>
									<input type="radio" name="rightans[]" value="1" <?php echo ($optArr->qto_right_ans==1) ? 'checked' : ''; ?>>
									<input type="hidden" name="rightansh[]" value="<?php echo ($optArr->qto_right_ans==1) ? 1 : 0; ?>">
								</div>
								<div class="clear">&nbsp;</div>
							</div>							
						</div>
						<?php
					}					
				}else{
					?>
					<div>
						<?php 
						for($i=1;$i<=4;$i++){ 
							?>
							<div class="col-md-12">
								<div class="optionCnt col-md-10">
									<div class="col-md-8">
										<div>
											<input type="text" name="qoptions[]" placeholder="Option 1">
										</div>
										<div class="image" style="display: <?php echo $display; ?>">
											<input type="file" name="qfile[]">
										</div>
									</div>
									<div class="col-md-4" align="center">
										Right Ans<br>
										<input type="radio" name="rightans[]" value="1">
										<input type="hidden" name="rightansh[]">
									</div>
									<div class="clear">&nbsp;</div>
								</div>						
							</div>
							<?php 
						} 
						?>
					</div>
					<?php
				}
				?>
			</div>
			<div>&nbsp;</div>
			<div class="form-actions">
				<?php 
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>$model->isNewRecord ? 'Create' : 'Save',
				)); 
				echo '&nbsp;&nbsp;';
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'button',
					'type'=>'primary',
					'label'=>'Cancel',
					'htmlOptions' => array('id' => 'cancelBtn')
				));
				?>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cancelBtn').click(function(){
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/questions';
		});		

		$('#Questions_qt_type').change(function(){
			var val = $(this).val();
			if(val==1){
				$('.question_options .image').addClass('hide');
				$('.question_options .viewimage').addClass('hide');
				$('#Questions_qt_image').parent().hide();
			}else if(val==2){
				$('.question_options .image').removeClass('hide');
				$('.question_options .image').removeAttr('style');
				$('.question_options .viewimage').removeClass('hide');
				$('.question_options .viewimage').removeAttr('style');
				$('#Questions_qt_image').parent().removeAttr('style');
				$('#Questions_qt_image').parent().removeClass('hide');
			}
		});

		$('.addMoreOptions').click(function(){
			var type = $('#Questions_qt_type').val();
			if(type==1){
				$('.question_options .image').hide();
			}else{
				$('.question_options .image').show();
				$('.question_options .image').removeClass('hide');
				$('.question_options .image').removeAttr('style');
			}

			var html = $('.optionCnt').html();
			var newHtml = '';
			newHtml += '<div class="col-md-12">';
			newHtml += '<div class="col-md-10">';
			newHtml += html;
			newHtml += '</div>';
			newHtml += '<div class="col-md-2"><a href="javascript:void(0);" class="removeOption" qtid=""><b><i class="glyphicon glyphicon-remove"></i></b></a></div>';
			newHtml += '<div class="clear">&nbsp;</div>';
			newHtml += '</div>';
			$('.optionCnt').parent().parent().append(newHtml);
		});

		$( ".add-edit-question-form" ).on( "click", "a.removeOption", function() {
			var obj = $(this);
			var qtid = $(obj).attr('qtid');
			var con = confirm('Are you sure want to remove this option?');
			var url = '<?php echo Yii::app()->baseUrl; ?>/admin/questions/deleteoption';
			if(con){
				if(qtid!='' && typeof(qtid)!='undefined'){
					$.ajax({
	                  type:'POST',
	                  url:url,
	                  data:{qtid:qtid},
	                  success:function(html){
	                  	if(html){
	                		$(obj).parent().parent().remove();  		
	                  	}
	                  },
	                });
				}else{
					$(obj).parent().parent().remove();
				}
			}
		});

		$( ".add-edit-question-form" ).on( "click", "input[type='radio']", function() {
			if($(this).is(':checked')){
				$(this).parent().find("input[type='hidden']").val(1);
			}else{
				$(this).parent().find("input[type='hidden']").val(0);
			}
		});
	});
</script>