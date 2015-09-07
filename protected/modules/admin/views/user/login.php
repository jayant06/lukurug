<?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'login-form',
        'type'=>'vertical',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
            'class'=>'form-signin',
        )    
    )); 
?>
	<?php if(Yii::app()->user->hasFlash('success')):?>
      <div class="alert alert-success">
          <button class="close" data-dismiss="alert" type="button">&times;</button>                              
          <?php echo Yii::app()->user->getFlash('success'); ?>
      </div>
    <?php elseif(Yii::app()->user->hasFlash('error')): ?>
      <div class="alert alert-danger">
          <button class="close" data-dismiss="alert" type="button">&times;</button>
          <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
    <?php endif; ?>
    <h3 class="form-signin-heading"><?php echo Yii::app()->params['title']?> - Administrator</h3>    
	<?php echo $form->textFieldRow($model,'username',array('class'=>'input-block-level','placeholder'=>'Email address','labelOptions'=>array('label'=>false))); ?>    
    <?php echo $form->passwordFieldRow($model,'password',array('class'=>'input-block-level','placeholder'=>'Password','labelOptions'=>array('label'=>false))); ?>    
    <label for="LoginForm_rememberMe" class="checkbox">
    	<?php echo $form->checkBox($model,'rememberMe',array('class'=>'nomargin','uncheckValue'=>'','hiddenField'=>false)); ?>
        Remember me next time
    </label>
    <p><?php echo CHtml::submitButton('Login', array('class'=>'btn btn-large btn-block btn-primary')); ?></p>
    <?php echo CHtml::link('Forgot Password?',array('/admin/user/forgotpassword')); ?>
    <!--<button class="btn btn-large btn-primary" type="submit">Sign in</button>-->
<?php $this->endWidget(); ?>

