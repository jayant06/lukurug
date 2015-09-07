<?php
/* @var $this AuthassignmentController */
/* @var $model Authassignment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authassignment-assignment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'itemname'); ?>
		<?php 
			$lists = CHtml::listData($item, 'name', 'name');
			
			echo CHtml::dropDownList('itemname', $model, $lists, array(
				'empty' => 'Select a role',
			));
		?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userid'); ?>
		<?php 
			
			$list = CHtml::listData($user, 'id', 'username');
			//echo $form->textField($model,'userid'); 
			echo CHtml::dropDownList('userid', $model, $list, array(
				'empty' => 'Select a user',
			));
		?>
		<?php echo $form->error($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bizrule'); ?>
		<?php echo $form->textField($model,'bizrule'); ?>
		<?php echo $form->error($model,'bizrule'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php echo $form->textField($model,'data'); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->