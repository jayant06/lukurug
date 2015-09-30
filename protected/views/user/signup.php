<div class="container music_aboutcontainer">
  <div class="music_inner">
    <div class="music_signup">
    <h1>Create Account</h1>
    </div>
    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'type'=>'horizontal',
    )); ?>
    <fieldset> 
        <legend></legend>
        <div class="music_signup_form">
        <?php echo $form->textFieldRow($model, 'u_first_name', array('placeholder'=>'Full Name','class'=>'span3 music_signup_textfield')); ?>
        <?php echo $form->textFieldRow($model, 'u_last_name', array('placeholder'=>'Last Name','class'=>'span3 music_signup_textfield')); ?>
        <?php echo $form->textFieldRow($model, 'u_email', array('placeholder'=>'Email Adress','class'=>'span3 music_signup_textfield')); ?>
        <?php 
        if($model->u_gender==''){
            $model->u_gender = 1;	
        } 
        ?>
        <?php echo $form->radioButtonListInlineRow($model, 'u_gender', array(1 => 'Male',2 =>'Female')); ?>
        <?php echo $form->passwordFieldRow($model, 'u_password', array('placeholder'=>'Password','class'=>'span3 music_signup_textfield')); ?>
        <?php echo $form->passwordFieldRow($model, 'u_repeat_password', array('placeholder'=>'Confirm Password','class'=>'span3 music_signup_textfield')); ?>
        <div class="control-group">
            <div class="controls">
                <?php echo $form->checkbox($model,'terms_conditions',array('uncheckValue'=>''));?>
                <?php echo $form->labelEx($model,'terms_conditions',array('class'=>'inlinedisplay'));?>
                <span><?php echo CHtml::link('Terms and Conditions',array('/terms'));?></span>
                <div><?php echo $form->error($model,'terms_conditions');?></div>    
            </div>
        </div>
        
       </div>       
        
        </fieldset>

	<div class="form-actions music_signup_action_">
	    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Sign Up', 'htmlOptions'=>array('class'=>'music_login_btn'))); ?>	    
	</div>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
