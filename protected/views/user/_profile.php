<style type="text/css">
	.address .left{
		float: left;
		width: 50%;
	}
</style>
<div class="row-fluid">
	<div class="block nomargin">
	    <div class="navbar navbar-inner block-header">
	        <div class="muted pull-left">Profile</div>
	  		<div class="muted pull-right">Fields with <span class="required">*</span> are required.</div>
	    </div>
    
	    <div class="block-content collapse in" >
	        <div class="span12">
				<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				    'id'=>'verticalForm',
				    'type'=>'horizontal',    
				)); 
				?>
				<?php echo $form->textFieldRow($model, 'u_email', array('class'=>'span4')); ?>

				<?php echo $form->textFieldRow($model, 'u_first_name', array('class'=>'span4')); ?>
				<?php echo $form->textFieldRow($model, 'u_last_name', array('class'=>'span4')); ?>

				<?php 
					if($model->u_gender==''){
						$model->u_gender = 1;	
					} 
				?>
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
		        <div class="control-group" style="display:<?php echo (empty($model->u_image)) ? 'none' : 'block'; ?>;">
		            <label class="control-label">&nbsp;</label>
		            <div class="controls" id="uploadedimage">
		            	<img src="<?php echo Yii::app()->baseUrl; ?>/storage/users/<?php echo $model->u_image; ?>" width="100">
		            </div>
		        </div>
				<?php echo $form->radioButtonListInlineRow($model, 'u_gender', array(1 => 'Male',2 =>'Female')); ?>
				<div class="col-lg-12">
					<div class="control-group ">
						<label for="user_cources" class="control-label required">Assign Cources</label>
						<div class="controls">
							<?php
							$courcesData = Categories::model()->findAll();
							$cources = CHtml::listData($courcesData,'cat_id','cat_name');
							$cids = array();
							if(!empty($model->uCources)){
								foreach ($model->uCources as $ckey => $cArr) {
									$cids[$cArr->cr_category_id] = $cArr->cr_category_id;	
								}
							}
							?>
							<select name="user_cources[]" id="user_cources" multiple="multiple" style="width:250px;">	
								<?php
								foreach ($cources as $cid => $cname) {
									?>
									<option value="<?php echo $cid; ?>" <?php echo (!empty($cids[$cid])) ? 'selected' : ''; ?>><?php echo $cname; ?></option>
									<?php
								}
								?>
							</select>	
						</div>
					</div>							
				</div>	
				<div style="clear:both;">&nbsp;</div>
				<div class="form-actions">
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Update')); ?>
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
				</div>				
				<?php $this->endWidget(); ?>
			
				<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				    'id'=>'user-address',
				    'type'=>'horizontal',  
				    'action' => array('user/saveaddress')  
				)); 
				?>
				<div class="address">
					<div class="left">
						<div><b>Present address</b></div>
						<div>
							<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_type][1]','value' => 1)); ?>
							<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_id][1]','value' => (!empty($address[1]['uad_id'])) ? $address[1]['uad_id']:'')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_add1', array('value' => (!empty($address[1]['uad_add1'])) ? $address[1]['uad_add1']:'','name' => 'UserAddress[uad_add1][1]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_add2', array('value' => (!empty($address[1]['uad_add2'])) ? $address[1]['uad_add2']:'','name' => 'UserAddress[uad_add2][1]')); ?>
							<div style="display:none;">
								<?php echo $form->dropDownListRow($userAddressModel,'uad_country_id', $countries,array('options' => array((!empty($address[1]['uad_country_id'])) ? $address[1]['uad_country_id']:''=>array('selected'=>true)),'empty' => 'Select County','name' => 'UserAddress[uad_country_id][1]')); ?>
							</div>
							<?php echo $form->dropDownListRow($userAddressModel, 'uad_state_id', $states1,array('options' => array((!empty($address[1]['uad_state_id'])) ? $address[1]['uad_state_id']:''=>array('selected'=>true)),'empty' => 'Select State','name' => 'UserAddress[uad_state_id][1]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_city', array('value' => (!empty($address[1]['uad_city'])) ? $address[1]['uad_city']:'','name' => 'UserAddress[uad_city][1]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_zipcode', array('value' => (!empty($address[1]['uad_zipcode'])) ? $address[1]['uad_zipcode']:'','name' => 'UserAddress[uad_zipcode][1]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_mobile', array('value' => (!empty($address[1]['uad_mobile'])) ? $address[1]['uad_mobile']:'','name' => 'UserAddress[uad_mobile][1]')); ?>
							<input type="checkbox" name="shippingChk" id="shippingChk">&nbsp;Billing Address same as Shipping Address
						</div>
					</div>
					<div class="left">
						<div><b>Permanent address</b></div>
						<div>
							<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_type][2]','value' => 2)); ?>
							<?php echo $form->hiddenField($userAddressModel, 'uad_type', array('name' => 'UserAddress[uad_id][2]','value' => (!empty($address[2]['uad_id'])) ? $address[2]['uad_id']:'')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_add1', array('value' => (!empty($address[2]['uad_add1'])) ? $address[2]['uad_add1']:'','name' => 'UserAddress[uad_add1][2]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_add2', array('value' => (!empty($address[2]['uad_add2'])) ? $address[2]['uad_add2']:'','name' => 'UserAddress[uad_add2][2]')); ?>
							<div style="display:none;">
								<?php echo $form->dropDownListRow($userAddressModel, 'uad_country_id', $countries, array('options' => array((!empty($address[2]['uad_country_id'])) ? $address[2]['uad_country_id']:''=>array('selected'=>true)),'empty' => 'Select County','name' => 'UserAddress[uad_country_id][2]')); ?>
							</div>
							<?php echo $form->dropDownListRow($userAddressModel, 'uad_state_id', $states2, array('options' => array((!empty($address[2]['uad_state_id'])) ? $address[2]['uad_state_id']:''=>array('selected'=>true)),'empty' => 'Select State','name' => 'UserAddress[uad_state_id][2]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_city', array('value' => (!empty($address[2]['uad_city'])) ? $address[2]['uad_city']:'','name' => 'UserAddress[uad_city][2]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_zipcode', array('value' => (!empty($address[2]['uad_zipcode'])) ? $address[2]['uad_zipcode']:'','name' => 'UserAddress[uad_zipcode][2]')); ?>
							<?php echo $form->textFieldRow($userAddressModel, 'uad_mobile', array('value' => (!empty($address[2]['uad_mobile'])) ? $address[2]['uad_mobile']:'','name' => 'UserAddress[uad_mobile][2]')); ?>
						</div>
					</div>
				</div>
				<div style="clear:both;">&nbsp;</div>				
				<div class="form-actions">
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Update')); ?>
				    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
				</div>				
				<?php $this->endWidget(); ?>
			</div>
       </div>
	</div>	
</div>  
<div style="clear:both;"></div>