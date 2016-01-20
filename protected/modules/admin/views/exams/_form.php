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
			$mainCriteria = new CDbCriteria;
			$mainCriteria->condition = 'cat_parent_id=0 AND cat_parent_type=0';
			$mainCategoryData = Categories::model()->findAll($mainCriteria);
			$mainCategories = CHtml::listData($mainCategoryData,'cat_id','cat_name');
			?>
			<label for="main_category_id">Main Course</label>
			<select id="main_category_id" name="main_category_id" class="form-control">
				<option value="">--Parent Course--</option>
				<?php
				if(!empty($mainCategories)){
					foreach ($mainCategories as $mcatid => $mcatname) {
						?>
						<option value="<?php echo $mcatid; ?>"><?php echo $mcatname; ?></option>					
						<?php
					}
				}
				?>					
			</select>
			<label for="sub_category_id">Sub Course</label>
			<select id="sub_category_id" name="sub_category_id" class="form-control"></select>
			<?php
			$cources = array();
			if(!empty($model->ex_category_id)){
				$criteria=new CDbCriteria;
				$criteria->condition = 'cat_id="'.$model->ex_category_id.'"';
				$courcesData = Categories::model()->findAll($criteria);
				$cources = CHtml::listData($courcesData,'cat_id','cat_name');
			}
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

		$('#main_category_id').change(function(){
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->baseUrl; ?>/admin/categories/subcategories',
				data:{maincatid:$('#main_category_id').val()},
				dataType:'JSON',
				success:function(data){
					var html = '<option value="">--Select Sub Course--</option>';
					if(data){
						for(var i=0;i<data.length;i++){
							html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
						}
					}
					$('#sub_category_id').html(html);
					$('#Exams_ex_category_id').html('<option value="">--Select Course--</option>');
				}
			});
		});

		$('#sub_category_id').change(function(){
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->baseUrl; ?>/admin/categories/subcategories',
				data:{maincatid:$('#sub_category_id').val()},
				dataType:'JSON',
				success:function(data){
					var html = '<option value="">--Select Course--</option>';
					if(data){
						for(var i=0;i<data.length;i++){
							html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
						}
					}
					$('#Exams_ex_category_id').html(html);
				}
			});
		});
	});
</script>
