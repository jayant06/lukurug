<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        'ACCOUNT INFO'=>array(
        	'content'=>$this->renderPartial(
        		'_profile',array(
        			'model' => $model,
        			'userAddressModel' => $userAddressModel,
        			'countries' => $countries,
        			'states1' => $states1,
        			'states2' => $states2,
        			'address' => $address
        		),
        		true
        	),
        	'id' => 'accountInfoTab'
        ),                
    ),    
)); 
?>			
<script type="text/javascript">
	$(document).ready(function($) {
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
			