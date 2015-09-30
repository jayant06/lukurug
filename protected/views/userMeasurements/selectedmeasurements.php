<style type="text/css">
	.tabsSelectedMeasurement{
		float:left;width:48%;padding:5px;border:1px solid #CCC;border-radius:5px;background: #EEE;margin-bottom: 5px;
	}
</style>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
      		<div style="float:left;">
      			<h4 class="modal-title" id="myModalLabel">
		        	Selected Measurements
	        	</h4>
      		</div>
      		<div style="float:left;">
      			Selected Measurement
      		</div>
      		<div style="float:left;">
      			<input type="text" name="checkout_measurement_confirm" id="checkout_measurement_confirm">
      		</div>
      		<div style="float:left;">
      			<input type="button" name="confirm_selected" id="confirm_selected" value="CONFIRM">
      		</div>
      		<div style="float:right;">
      			<button type="button" class="close closeSelectedMeasurement" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		</div>
      		<div style="clear:both;"></div>
      	</div>
      	<div class="modal-body">
      		<div>
      			<div align="center">
      				<b>Choose any one of the following measurement options</b>
      			</div>
      			<div>
      				<div class="tabsSelectedMeasurement" style="margin-right:5px;">
      					<div align="center"><b>Standard Size</b></div>
      					<?php
      					if(!empty($userMesurements[0])){
      						foreach ($userMesurements[0] as $key1 => $arr1) {
      							?>
      							<a href="javascript:void(0);" rel="<?php echo $arr1->umr_name; ?>" id="<?php echo $arr1->umr_id; ?>" class="select">
      								<div><?php echo $arr1->umr_name; ?></div>
      							</a>
      							<?php
      						}
      					}
      					?>      					
      					<div align="right">
                                          <!-- <a href="<?php echo Yii::app()->baseUrl; ?>/userMeasurements/create/?type=1" id="measurementModal1" data-toggle="modal" data-target="measurementModal1"></a> -->
      						<?php 
                                          echo CHtml::link('Add New','javascript:void(0);',array('class' => 'measurementModal1')); 
                                          ?>
      					</div>
      				</div>
      				<div class="tabsSelectedMeasurement">
      					<div align="center"><b>Send a Shirt</b></div>
      					<?php
      					if(!empty($userMesurements[1])){
      						foreach ($userMesurements[1] as $key2 => $arr2) {
      							?>
      							<a href="javascript:void(0);" rel="<?php echo $arr2->umr_name; ?>" id="<?php echo $arr2->umr_id; ?>" class="select">
      								<div><?php echo $arr2->umr_name; ?></div>
      							</a>
      							<?php
      						}
      					}
      					?>
      					<div align="right">
      						<?php 
                                          //echo CHtml::link('Create New Profile',array('userMeasurements/create','type' => 3),array('data-toggle' => 'modal' ,'data-target' => '#measurementModal3')); 
                                          echo CHtml::link('Create New Profile','javascript:void(0);',array('class' => 'measurementModal3')); 
                                          ?>
      					</div>
      				</div>
      				<div style="clear:both;"></div>
      			</div>
      			<div>
      				<div class="tabsSelectedMeasurement" style="margin-right:5px;">
      					<div align="center"><b>Shirt Measurements</b></div>
      					<?php
      					if(!empty($userMesurements[2])){
      						foreach ($userMesurements[2] as $key3 => $arr3) {
      							?>
      							<a href="javascript:void(0);" rel="<?php echo $arr3->umr_name; ?>" id="<?php echo $arr3->umr_id; ?>"  class="select">
      								<div><?php echo $arr3->umr_name; ?></div>
      							</a>
      							<?php
      						}
      					}
      					?>
      					<div align="right">
      						<?php 
                                          //echo CHtml::link('Create New Profile',array('userMeasurements/create','type' => 4),array('data-toggle' => 'modal' ,'data-target' => '#measurementModal4')); 
                                          echo CHtml::link('Create New Profile','javascript:void(0);',array('class' => 'measurementModal4')); 
                                          ?>
      					</div>
      				</div>
      				<div class="tabsSelectedMeasurement">
      					<div align="center"><b>Body Measurements</b></div>
      					<?php
      					if(!empty($userMesurements[3])){
      						foreach ($userMesurements[3] as $key4 => $arr4) {
      							?>
      							<a href="javascript:void(0);" rel="<?php echo $arr4->umr_name; ?>" id="<?php echo $arr4->umr_id; ?>" class="select">
      								<div><?php echo $arr4->umr_name; ?></div>
      							</a>
      							<?php
      						}
      					}
      					?>
      					<div align="right">
      						<?php 
                                          //echo CHtml::link('Add New',array('userMeasurements/create','type' => 6),array('data-toggle' => 'modal' ,'data-target' => '#measurementModal6')); 
                                          echo CHtml::link('Add New','javascript:void(0);',array('class' => 'measurementModal6'));
                                          ?>
      					</div>
      				</div>
      				<div style="clear:both;"></div>
      			</div>
      		</div>
      	</div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function($) {
            $('.measurementModal1').click(function(event) {
                  location.hash = 'measurementModal1';
                  location.reload();
            });
            $('.measurementModal3').click(function(event) {
                  location.hash = 'measurementModal3';
                  location.reload();
            });
            $('.measurementModal4').click(function(event) {
                  location.hash = 'measurementModal4';
                  location.reload();
            });
            $('.measurementModal6').click(function(event) {
                  location.hash = 'measurementModal6';
                  location.reload();
            });
		$('.tabsSelectedMeasurement a.select').click(function(event) {
			event.preventDefault();
			var name = $(this).attr('rel');
			var id = $(this).attr('id');
			$('#checkout_measurement_confirm').val(name);
			$('#checkout_measurement_confirm').attr('rel',id);
		});	

		$('#confirm_selected').click(function(event) {
			var id = $('#checkout_measurement_confirm').attr('rel');
			$.ajax({
				url: '<?php echo Yii::app()->baseUrl; ?>/cart/updateusermeasurement',
				type: 'POST',
				data: {id: id,fabid:'<?php echo $fab_id; ?>'},
				success:function(data){
					if(data){
						if(data=='success'){
							alert('Measurement selected successfully.');
							$(".closeSelectedMeasurement").click();
							//$("#cartModal").modal('show');
						}
					}
				}
			});
			
		});
	});
</script>