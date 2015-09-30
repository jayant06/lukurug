<div class="row">
    <div class="col-lg-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'items-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),	
		)); ?>

			<p class="help-block">Fields with <span class="required">*</span> are required.</p>

			<?php echo $form->errorSummary($model); ?>

			<?php echo $form->textFieldRow($model,'itm_name',array('class'=>'form-control','maxlength'=>255)); ?>

			<?php 
			$categoryData = Subcategories::model()->findAll();
			$categories = CHtml::listData($categoryData,'sub_id','sub_cat_name');
			//prd($categories);
			echo $form->dropDownListRow($model,'itm_subcategory_id',$categories,array('class'=>'form-control','empty' => 'Select Subcategory')); 
			?>

			<?php 
			$fabricData = Fabrics::model()->findAll();
			$fabrics = CHtml::listData($fabricData,'fab_id','fab_name');
			echo $form->dropDownListRow($model,'itm_fabric_id',$fabrics,array('class'=>'form-control','empty' => 'Select Fabric')); 
			?>

			<?php echo $form->textFieldRow($model,'itm_price',array('class'=>'form-control')); ?>

			<?php echo $form->textFieldRow($model,'itm_size',array('class'=>'form-control','maxlength'=>200)); ?>

			<?php echo $form->textFieldRow($model,'itm_qty',array('class'=>'form-control')); ?>
			<div>&nbsp;</div>
			<div>
			<?php
			if(!empty($model->itm_id) && !empty($model->itm_photo)){
				$itmimage = Yii::getPathOfAlias('webroot').'/storage/products/'.$model->itm_photo;
				if(file_exists($itmimage)){
					?>
					<img src="<?php echo Yii::app()->baseUrl; ?>/storage/products/<?php echo $model->itm_photo; ?>" width="200">
					<?php
				}
			}
			?>
			</div>
			<div>&nbsp;</div>
			<?php echo $form->fileFieldRow($model,'itm_photo',array('class'=>'form-control','maxlength'=>200)); ?>

			<?php echo $form->textAreaRow($model,'itm_details',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>

			<?php echo $form->textFieldRow($model,'itm_meta_title',array('class'=>'form-control','maxlength'=>255)); ?>

			<?php echo $form->textAreaRow($model,'itm_meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>

			<?php echo $form->textAreaRow($model,'itm_meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
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
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/items';
		});
	});
</script>