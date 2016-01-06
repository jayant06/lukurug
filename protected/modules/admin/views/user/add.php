<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Add User
            </div>
            <div class="panel-body">
				<div class="row">
    				<div class="col-lg-12">
    					<?php /** @var BootActiveForm $form */
						$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
						    'id'=>'verticalForm',
						    'type'=>'horizontal',    
						)); 
						?>
						<div class="col-lg-6">
							<?php echo $form->textFieldRow($model, 'u_first_name', array('class'=>'form-control')); ?>
							<?php echo $form->textFieldRow($model, 'u_last_name', array('class'=>'form-control')); ?>
							<?php echo $form->textFieldRow($model, 'u_email', array('class'=>'form-control')); ?>
							<?php echo $form->passwordFieldRow($model, 'u_password', array('class'=>'form-control')); ?>
							<?php echo $form->passwordFieldRow($model, 'u_repeat_password', array('class'=>'form-control')); ?>
							<?php 
							if($model->u_gender==''){
								$model->u_gender = 1;	
							} 
							?>
							<?php echo $form->radioButtonListInlineRow($model, 'u_gender', array(1 => 'Male',2 =>'Female')); ?>
							<div>&nbsp;</div>
						</div>
						<div class="col-lg-12">
							<div class="address">
								<div class="col-lg-6">
									<div><b>Present address</b></div>
									<div>
										<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_type][1]','value' => 1)); ?>
										<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_id][1]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_add1',array('name' => 'UserAddress[uad_add1][1]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_add2',array('name' => 'UserAddress[uad_add2][1]')); ?>
										<?php echo $form->dropDownListRow($userAddressModel,'uad_country_id', $countries,array('empty' => 'Select County','name' => 'UserAddress[uad_country_id][1]')); ?>
										<?php echo $form->dropDownListRow($userAddressModel, 'uad_state_id', $states1,array('empty' => 'Select State','name' => 'UserAddress[uad_state_id][1]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_city', array('name' => 'UserAddress[uad_city][1]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_zipcode', array('name' => 'UserAddress[uad_zipcode][1]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_mobile', array('name' => 'UserAddress[uad_mobile][1]')); ?>
										<input type="checkbox" name="shippingChk" id="shippingChk">&nbsp;Billing Address same as Shipping Address
									</div>
								</div>
								<div class="col-lg-6">
									<div><b>Permanent address</b></div>
									<div>
										<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_type][2]','value' => 2)); ?>
										<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_id][2]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_add1', array('name' => 'UserAddress[uad_add1][2]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_add2', array('name' => 'UserAddress[uad_add2][2]')); ?>
										<?php echo $form->dropDownListRow($userAddressModel, 'uad_country_id', $countries, array('empty' => 'Select County','name' => 'UserAddress[uad_country_id][2]')); ?>
										<?php echo $form->dropDownListRow($userAddressModel, 'uad_state_id', $states2, array('empty' => 'Select State','name' => 'UserAddress[uad_state_id][2]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_city', array('name' => 'UserAddress[uad_city][2]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_zipcode', array('name' => 'UserAddress[uad_zipcode][2]')); ?>
										<?php echo $form->textFieldRow($userAddressModel, 'uad_mobile', array('name' => 'UserAddress[uad_mobile][2]')); ?>
									</div>
								</div>
							</div>
						</div>
						<div style="clear:both;"></div>						
						<div class="form-actions">
							<?php 
							$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'submit',
								'type'=>'primary',
								'label'=>$model->isNewRecord ? 'Create' : 'Save',
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
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function($) {
		$('#cancelBtn').click(function(){
			window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/user/userlist';
		});

		$('#UserAddress_uad_country_id_1').change(function(event) {
			$.ajax({
				url: '<?php echo Yii::app()->baseUrl; ?>/user/states',
				type: 'POST',
				dataType: 'html',
				async:false,
				data: {cnt_id: $(this).val()},
			})
			.done(function(data) {
				$('#UserAddress_uad_state_id_1').html(data);
			});
		});	
		$('#UserAddress_uad_country_id_2').change(function(event) {
			$.ajax({
				url: '<?php echo Yii::app()->baseUrl; ?>/user/states',
				type: 'POST',
				dataType: 'html',
				async:false,
				data: {cnt_id: $(this).val()},
			})
			.done(function(data) {
				$('#UserAddress_uad_state_id_2').html(data);
			});
		});

		$('#shippingChk').click(function(event) {
			if($(this).is(':checked')==true){
				$('#UserAddress_uad_add1_2').val($('#UserAddress_uad_add1_1').val());
				$('#UserAddress_uad_add2_2').val($('#UserAddress_uad_add2_1').val());
				$('#UserAddress_uad_country_id_2').val($('#UserAddress_uad_country_id_1').val());
				$('#UserAddress_uad_country_id_2').trigger('change');
				$('#UserAddress_uad_state_id_2').val($('#UserAddress_uad_state_id_1').val());
				$('#UserAddress_uad_city_2').val($('#UserAddress_uad_city_1').val());
				$('#UserAddress_uad_zipcode_2').val($('#UserAddress_uad_zipcode_1').val());
				$('#UserAddress_uad_mobile_2').val($('#UserAddress_uad_mobile_1').val());
			}else{
				$('#UserAddress_uad_add1_2').val('');
				$('#UserAddress_uad_add2_2').val('');
				$('#UserAddress_uad_country_id_2 option[value=""]').attr('selected', true);
				$('#UserAddress_uad_country_id_2').val('');
				$('#UserAddress_uad_country_id_2').trigger('change');
				$('#UserAddress_uad_city_2').val('');
				$('#UserAddress_uad_zipcode_2').val('');
				$('#UserAddress_uad_mobile_2').val('');
			}
		});
	});
</script>		