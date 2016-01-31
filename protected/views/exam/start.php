<div align="center" class="row">
	<h3>Ready for Exam: <?php echo $examdata['ex_title']; ?></h3>
	<div class="col-sm-12 col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
			  <h3 class="panel-title">Instructions</h3>
			</div>
			<div class="panel-body" align="left">
				<ul>
					<li>Don't refresh page and don't use next and previous buttons of browser otherwise your exam will be terminated.</li>
					<li>Your exam will be started as soon as you will click on start btton</li>
					<li>If exam doesn't start after clicking start button then please check messasge for wait if it doesn't appear then please contact to admin.</li>
				</ul>
				<div align="center">
					<?php
		                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		                    'id'=>'start-form',
		                    'type'=>'vertical',
		                    'enableAjaxValidation'=>false,
		                    'htmlOptions'=>array(
		                        'class'=>'form-start',
		                    ),
		                    'action'=> Yii::app()->baseUrl.'/exam/paper/'.$ur_exam_id,
		                )); 
		            ?>
		            <input type="hidden" name="ur_exam_id" value="<?php echo $ur_exam_id;?>" />
		            <label>Medium: <select id="medium" name="medium"><option value="English">English</option></select></label>
					<?php //$model = array(); echo $form->textFieldRow('k','username',array('class'=>'input-block-level','placeholder'=>'Email address','labelOptions'=>array('label'=>false))); ?>    
					<input type="submit" class="btn btn-default" value="Start" />
					<?php if($wait_for_start){ ?><div style="color:red">You will be able to start as soon as administrator allow, please wait for few seconds and try again or contact to administrator.</div><?php }?>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>