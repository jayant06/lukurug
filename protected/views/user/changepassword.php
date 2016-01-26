<div align="center" class="row">
	<div class="col-sm-12 col-md-4 col-md-offset-4">
    	<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Change Password</h3>
      		</div>
      		<div class="panel-body" align="left">
      			<?php /** @var BootActiveForm $form */
					$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					    'id'=>'verticalForm',
					    'type'=>'vertical',
					)); 
				?>
				<div class="form-group"><?php echo $form->passwordFieldRow($model, 'old_password', array('class'=>'input-block-level')); ?></div>
				<div class="form-group"><?php echo $form->passwordFieldRow($model, 'new_password', array('class'=>'input-block-level')); ?></div>
				<div class="form-group"><?php echo $form->passwordFieldRow($model, 'new_repeat_password', array('class'=>'input-block-level')); ?></div>
				<div class="form-actions">
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
				</div>
				<?php $this->endWidget(); ?>
	        </div>
	    </div>
	</div>
</div>