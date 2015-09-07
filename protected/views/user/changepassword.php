<div class="row-fluid">
	<div class="block nomargin">
		<div class="navbar navbar-inner block-header">
		<div class="muted pull-left">Change Password</div>
	  		<div class="muted pull-right">Fields with <span class="required">*</span> are required.</div>
	    </div>	    
	    <div class="block-content collapse in" >
	        <div class="span12">
	        	<?php /** @var BootActiveForm $form */
					$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					    'id'=>'verticalForm',
					    'type'=>'horizontal',    
					)); 
				?>
				<?php echo $form->passwordFieldRow($model, 'old_password', array('class'=>'span4')); ?>
				<?php echo $form->passwordFieldRow($model, 'new_password', array('class'=>'span4')); ?>
				<?php echo $form->passwordFieldRow($model, 'new_repeat_password', array('class'=>'span4')); ?>
				<div class="form-actions">
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
				</div>
				<?php $this->endWidget(); ?>
	        </div>
	    </div>
	</div>
</div>