<div align="center" class="row">
    <div class="col-sm-12 col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Forgot Password</h3>
            </div>
            <div class="panel-body" align="left">

                <?php /** @var BootActiveForm $form */
                    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'login-form',
                        'type'=>'vertical',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array(
                            'class'=>'',
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
                	<div class="form-group"><?php echo $form->textFieldRow($model,'username',array('class'=>'form-control','placeholder'=>'Email address','labelOptions'=>array('label'=>false))); ?></div>
                    <div class="form-group"><?php echo CHtml::submitButton('Submit', array('class'=>'btn btn-large btn-block btn-primary')); ?></div>
                    <?php echo CHtml::link('Back to login',array('/site/login')); ?>
                    <!--<button class="btn btn-large btn-primary" type="submit">Sign in</button>-->
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

