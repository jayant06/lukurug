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
			$categories = array();
			if(!empty($model->categoryType)){
				if($model->categoryType==2)
					$criteria->condition = 'cat_parent_id=0 AND cat_parent_type=0';
				else
					$criteria->condition = 'cat_parent_id!=0 AND cat_parent_type=2';

				$criteria->order = 'cat_name';
				if($model->categoryType!=1){
					$categoryData = Categories::model()->findAll($criteria);
					$categories = CHtml::listData($categoryData,'cat_id','cat_name');
				}
			}	
			if($model->categoryType==3){
				$mainCriteria = new CDbCriteria;
				$mainCriteria->condition = 'cat_parent_id=0 AND cat_parent_type=0';
				$mainCriteria->order = 'cat_name';
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
				<?php	
			}
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
			window.location = '<?php echo Yii::app()->baseUrl."/admin/categories/index/?type=".$model->categoryType; ?>';
		});	
		$('#main_category_id').change(function(){
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->baseUrl; ?>/admin/categories/subcategories',
				data:{maincatid:$('#main_category_id').val()},
				dataType:'JSON',
				success:function(data){
					var html = '';
					if(data){
						for(var i=0;i<data.length;i++){
							html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
						}
					}
					$('#Categories_cat_parent_id').html(html);
				}
			});
		});
	});
</script>