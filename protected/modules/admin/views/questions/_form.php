<div class="row add-edit-question-form">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'questions-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),	
		)); ?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php 
			$examsData = Exams::model()->findAll();
			$exams = CHtml::listData($examsData,'ex_id','ex_title');
			echo $form->dropDownListRow($model,'qt_exam_id',$exams,array('class'=>'form-control','empty' => 'Select Exam')); 
			?>
			<?php echo $form->textFieldRow($model,'qt_name',array('class'=>'form-control','maxlength'=>255)); ?>
			<?php echo $form->textAreaRow($model,'qt_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php 
			$types = array(1 => 'Objective', 2 => 'Objective with image');
			echo $form->dropDownListRow($model,'qt_type',$types,array('class'=>'form-control')); 
			?>
			<?php echo $form->textFieldRow($model,'qt_marks',array('class'=>'form-control')); ?>
			<div>
				<label>Add options</label>
			</div>
			<div class="question_options">
				<?php
				$display = 'none';
				if(!empty($model->qt_type)){
					if($model->qt_type==2){
						$display = 'block';	
					}
				}
				if(!empty($model->qoptQat)){
					foreach ($model->qoptQat as $optKey => $optArr) {
						?>
						<div>
							<div class="left">
								<div>
									<input type="text" placeholder="Option 1" name="qoptions[]" value="<?php echo $optArr->qto_name; ?>">
								</div>
								<div class="image" style="display: <?php echo $display; ?>;">
									<input type="file" name="qfile[]">
								</div>
								<div style="display: <?php echo $display; ?>">
									<img src="<?php echo Yii::app()->baseUrl; ?>/storage/qoptions/<?php echo $optArr->qto_image; ?>" height="100">
								</div>
							</div>
							<div class="left"><a href="javascript:void(0);" class="removeOption" qtid='<?php echo $optArr->qto_id; ?>'><b>Remove</b></a></div>
							<div class="clear">&nbsp;</div>
						</div>
						<?php
					}					
				}
				?>
				<div class="optionCnt left">
					<div>
						<input type="text" name="qoptions[]" placeholder="Option 1">
					</div>
					<div class="image hide">
						<input type="file" name="qfile[]">
					</div>
				</div>
				<div class="left"><a href="javascript:void(0);" class="addMoreOptions"><b>Add More</b></a></div>
				<div class="clear">&nbsp;</div>
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
			}else if(val==2){
				$('.question_options .image').removeClass('hide');
				$('.question_options .image').removeAttr('style');
			}
		});

		$('.addMoreOptions').click(function(){
			var type = $('#Questions_qt_type').val();
			if(type==1){
				$('.question_options .image').hide();
			}else{
				$('.question_options .image').show();
			}

			var html = $('.optionCnt').html();
			var newHtml = '';
			newHtml += '<div><div class="left">';
			newHtml += html;
			newHtml += '</div><div class="left"><a href="javascript:void(0);" class="removeOption" qtid=""><b>Remove</b></a></div><div class="clear">&nbsp;</div></div>';
			$('.optionCnt').parent().append(newHtml);
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
	});
</script>