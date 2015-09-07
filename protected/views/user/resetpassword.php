<div class="container music_aboutcontainer">
	<div class="music_inner">
	    <div class="music_signup">
	    	<h1>Reset Your Password</h1>    
	    </div>
		<?php /** @var BootActiveForm $form */
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		    'id'=>'verticalForm',
		    'type'=>'horizontal',    
		)); ?>
		<fieldset> 
		    <legend></legend>		
		    <div class="music_signup_form">
			    <div class="control-group">
				    <?php echo $form->labelEx($model,'u_email',array('class'=>'control-label','required'=>false)); ?>
				    <div class="controls" style="line-height:30px;">
				    	<?php echo $model->u_email;?>
				    </div>
			    </div>
				<?php echo $form->passwordFieldRow($model, 'u_password', array('class'=>'span3 music_signup_textfield')); ?>
				<?php echo $form->passwordFieldRow($model, 'u_repeat_password', array('class'=>'span3 music_signup_textfield')); ?>
			</div>	
		</fieldset>
		<div class="form-actions music_signup_action_">
		    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit','htmlOptions'=>array('class'=>'music_signup_submit'))); ?>
		    <?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div>	
</div>