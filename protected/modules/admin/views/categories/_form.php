<div class="row">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'categories-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->textFieldRow($model,'cat_name',array('class'=>'form-control','maxlength'=>255)); ?>
			<?php echo $form->textAreaRow($model,'cat_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->textAreaRow($model,'cat_meta_title',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->textAreaRow($model,'cat_meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->textAreaRow($model,'cat_meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
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
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/categories';
		});
	});
</script>