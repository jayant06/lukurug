<div class="row">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'categories-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php 
			$criteria=new CDbCriteria;
			$criteria->condition = 'cat_parent_id=0';
			$categoryData = Categories::model()->findAll($criteria);
			$categories = CHtml::listData($categoryData,'cat_id','cat_name');
			echo $form->dropDownListRow($model,'cat_parent_id',$categories,array('class'=>'form-control','empty' => '--Parent Course--')); 
			?>
			<?php echo $form->textFieldRow($model,'cat_code',array('class'=>'form-control','readonly' =>true)); ?>
			<?php echo $form->textFieldRow($model,'cat_name',array('class'=>'form-control','maxlength'=>255)); ?>
			<?php echo $form->textAreaRow($model,'cat_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
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