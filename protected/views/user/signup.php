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
        <div class="control-group ">
            <label for="User_u_image" class="control-label">Image</label>
            <div class="controls">
                <?php
                $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                        'id'=>'uploadFile',
                        'config'=>array(
                            'action'=>Yii::app()->createUrl('user/upload'),
                            'allowedExtensions'=>array("jpg","jpeg","gif",'png'),
                            'sizeLimit'=>2*1024*1024,// maximum file size in bytes
                            'minSizeLimit'=>10*1024,// minimum file size in bytes
                            'onComplete'=>"js:function(id, fileName, responseJSON){ 
                                $('#uploadedimage').parent().show();
                                $('#uploadedimage').html('<img src=\'".Yii::app()->baseUrl."/storage/users/temp/'+fileName+'\' width=\'100\'><input type=\'hidden\' name=\'User[u_image]\' value=\''+fileName+'\'>');
                            }",
                            'messages'=>array(
                                'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                'emptyError'=>"{file} is empty, please select files again without it.",
                                'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                            ),
                            'showMessage'=>"js:function(message){ 
                                alert(message); 
                            }"
                        )
                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group" style="display:none;">
            <label class="control-label">&nbsp;</label>
            <div class="controls" id="uploadedimage"></div>
        </div>
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
