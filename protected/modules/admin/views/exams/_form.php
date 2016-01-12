<?php
$cs = Yii::app()->clientScript;     
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.simple.datetimepicker.css')
   ->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.simple.datetimepicker.js');
?>
<div class="row">
    <div class="col-lg-6">
		<?php 
		$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'categories-form',
			'enableAjaxValidation'=>false,
		)); 
		?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php
			$courcesData = Categories::model()->findAll();
			$cources = CHtml::listData($courcesData,'cat_id','cat_name');
			echo $form->dropDownListRow($model,'ex_category_id',$cources,array('class'=>'form-control','empty' => 'Select Course')); 
			?>
			<?php echo $form->textFieldRow($model,'ex_title',array('class'=>'form-control','maxlength'=>200)); ?>
			<?php echo $form->textAreaRow($model,'ex_details',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->textFieldRow($model,'ex_start_date_time',array('class'=>'form-control')); ?>
			<?php echo $form->textFieldRow($model,'ex_end_date_time',array('class'=>'form-control')); ?>
			<?php echo $form->textFieldRow($model,'ex_duration',array('class'=>'form-control','maxlength'=> 8,'style' => 'width:90px;')); ?>
			<?php echo $form->radioButtonListInlineRow($model, 'ex_is_practical', array(0 => 'No',1 =>'Yes')); ?>		
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
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/exams';
		});

		$('#Exams_ex_start_date_time').appendDtpicker();
		$('#Exams_ex_end_date_time').appendDtpicker();
		$('#Exams_ex_duration').mask('00:00:00',{placeholder: "__:__:__"});
	});
</script>
