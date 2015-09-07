<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Add User
            </div>
            <div class="panel-body">
				<div class="row">
    				<div class="col-lg-6">
    					<?php /** @var BootActiveForm $form */
						$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
						    'id'=>'verticalForm',
						    'type'=>'horizontal',    
						)); 
						?>
						<?php echo $form->textFieldRow($model, 'u_first_name', array('class'=>'form-control')); ?>
						<?php echo $form->textFieldRow($model, 'u_last_name', array('class'=>'form-control')); ?>
						<?php echo $form->textFieldRow($model, 'u_email', array('class'=>'form-control')); ?>
						<?php echo $form->passwordFieldRow($model, 'u_password', array('class'=>'form-control')); ?>
						<?php echo $form->passwordFieldRow($model, 'u_repeat_password', array('class'=>'form-control')); ?>
						<?php 
						if($model->u_gender==''){
							$model->u_gender = 1;	
						} 
						?>
						<?php echo $form->radioButtonListInlineRow($model, 'u_gender', array(1 => 'Male',2 =>'Female')); ?>
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
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cancelBtn').click(function(){
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/user/userlist';
		});
	});
</script>