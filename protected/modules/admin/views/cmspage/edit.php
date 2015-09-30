<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <?php echo $model->c_title;?> 
            </div>
            <div class="panel-body">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'cmspage-form',					
					// Please note: When you enable ajax validation, make sure the corresponding
					// controller action is handling ajax validation correctly.
					// There is a call to performAjaxValidation() commented in generated controller code.
					// See class documentation of CActiveForm for details on this.
					'enableAjaxValidation'=>false,
					'errorMessageCssClass'=>'error',
					'htmlOptions'=>array(
						'class'=>'form-horizontal',	
					)
				)); ?>
				<fieldset>	
					<div class="control-group">
						<?php echo $form->labelEx($model,'c_pagename',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'c_pagename',array('class' => 'form-control','readonly'=>true)); ?>
							<?php echo $form->error($model,'c_pagename'); ?>
						</div>
						
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'c_title',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'c_title',array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'c_title'); ?>
						</div>
					</div>

					<!-- <div class="control-group">
						<?php echo $form->labelEx($model,'c_subtitle',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'c_subtitle'); ?>
							<?php echo $form->error($model,'c_subtitle'); ?>
						</div>						
					</div> -->

					<div class="control-group">
						<?php echo $form->labelEx($model,'c_content',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textArea($model,'c_content',array('class'=>'form-control textarea','style'=>'width: 100%; height: 200px;')); ?>
							<?php echo $form->error($model,'c_content'); ?>
						</div>
						
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'c_meta_title',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'c_meta_title',array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'c_meta_title'); ?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'c_meta_keyword',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'c_meta_keyword',array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'c_meta_keyword'); ?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'c_meta_description',array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textArea($model,'c_meta_description',array('class'=>'form-control','rows'=>8)); ?>
							<?php echo $form->error($model,'c_meta_description'); ?>
						</div>
					</div>
					<div>&nbsp;</div>
					<div class="form-actions">
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
						<?php 
						echo '&nbsp;&nbsp;';
						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'primary',
							'label'=>'Cancel',
							'htmlOptions' => array('id' => 'cancelBtn')
						));
						?>
					</div>
				</fieldset>	
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>                
<script>
	$(function() {                    
        $('.textarea').ckeditor({width:'98%', height: '150px',toolbar: [
			{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
			[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
			{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
		]});
		$('#cancelBtn').click(function(){
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/cmspage';
		});
    });
</script>