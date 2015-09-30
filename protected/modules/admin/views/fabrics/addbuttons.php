<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Assign Buttons for "<?php echo $model->fab_name; ?>"
            </div>
            <div class="panel-body"> 
            	<?php 
            	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'id'=>'buttons-form',
					'enableAjaxValidation'=>false,					
				)); 
				?>
            	<table width="100%" cellpadding="2" cellspacing="">
            		<tr>
            			<?php
            			if(!empty($buttons)){
            				$i = 0;
            				foreach ($buttons as $key => $butArr) {
            					if($i==6){
            						?>
            						</tr><tr><td height="5"></td></tr><tr>
            						<?php
            						$i = 0;
            					}
            					?>
            					<td>
            						<table width="100%">
            							<tr>
			            					<td width="10%">
			            						<?php 
			            						$checked = false;
			            						if(in_array($butArr->but_id, $fabriButtons))
			            							$checked = true;
			            						echo CHtml::checkbox('buttonids[]',$checked,array('value' => $butArr->but_id)); 
			            						?>
			            					</td>
			            					<td align="left" width="90%">
			            						<?php echo $butArr->but_name; ?>
			            					</td>
		            					</tr>
	            					</table>
            					</td>
            					<?php
            					$i++;
            				}
            			}
            			?>
            		</tr>
            	</table>
            	<div>&nbsp;</div>
            	<div class="form-actions">
				<?php 
                        $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Add Buttons',
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
<script type="text/javascript">
      $(document).ready(function(){
            $('#cancelBtn').click(function(){
                  window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/fabrics';
            });
      });
</script>