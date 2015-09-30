<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Profile 
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-lg-6">
		            	<?php
						$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
						    'id'=>'verticalForm',
						    'type'=>'horizontal',    
						)); 
						?>
						<div>
							<?php echo $form->textFieldRow($model, 'u_email', array('class'=>'form-control')); ?>							
						</div>
						<div>
							<?php echo $form->textFieldRow($model, 'u_first_name', array('class'=>'form-control')); ?>
						</div>
						<div>
							<?php echo $form->textFieldRow($model, 'u_last_name', array('class'=>'form-control')); ?>
						</div>
						<div>&nbsp;</div>
						<div class="form-actions">
						    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Update')); ?>
						    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
						</div>
						<?php $this->endWidget(); ?>
					</div>
				</div>
            </div>
		</div>
	</div>
</div>
