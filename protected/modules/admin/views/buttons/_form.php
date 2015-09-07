<div class="row">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'buttons-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),	
		)); ?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->textFieldRow($model,'but_name',array('class'=>'form-control','maxlength'=>255)); ?>
			<div>&nbsp;</div>
			<div>
			<?php
			if(!empty($model->but_id) && !empty($model->but_image)){
				$butimage = Yii::getPathOfAlias('webroot').'/storage/buttons/'.$model->but_image;
				if(file_exists($butimage)){
					?>
					<img src="<?php echo Yii::app()->baseUrl; ?>/storage/buttons/<?php echo $model->but_image; ?>" width="200">
					<?php
				}
			}
			?>
			</div>
			<div>&nbsp;</div>
			<?php echo $form->fileFieldRow($model,'but_image',array('class'=>'form-control','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'but_price',array('class'=>'form-control')); ?>
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
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/buttons';
		});
	});
</script>