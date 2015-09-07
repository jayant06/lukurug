<?php
$cs = Yii::app()->clientScript;		
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.steps.min.js',CClientScript::POS_HEAD)
->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.bxslider.min.js',CClientScript::POS_HEAD)
->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.steps.css')
->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.bxslider.css');
?>
<style type="text/css">
	.customSTD{
		display: none;
	}
	.bodyFits li{
		display: inline-block !important;
		width: 32%;
	}
	.shoulderFit li{
		display: inline-block !important;
		width: 24%;
	}
	.bodyFits li.selected,.shoulderFit li.selected{
		border:2px solid #ccc;
	}
</style>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">
	        	<?php
	        	if($type==1 || $type==2)
	        		echo "Standard Size";
	        	else if($type==3)
	        		echo "Send a shirt";
	        	else if($type==4 || $type==5)
	        		echo "Shirt Measurements";
	        	else if($type==6)
	        		echo "Body Measurements";
	        	?>
        	</h4>
      	</div>
      	<div class="modal-body">
			<?php 
			$sizes = array(
				1 => '37 (14.75in)',
				2 => '38 (15in)',
				3 => '39 (15.5in)',
				4 => '40 (15.75in)',
				5 => '41 (16in)',
				6 => '42 (16.5in)',
				7 => '43 (17in)',
				8 => '44 (17.25in)',
				9 => '45 (17.5in)'
			);

			$collorSizes = array(
				"14" => '14 in.',
				"14.5" => '14.5 in.',
				"15" => '15 in. (Default)',
				"15.5" => '15.5 in.',
				"16" => '16 in.',
			);
			$shirtLength = array(
				"24" => '24 in.',
				"25" => '25 in.',
				"26" => '26 in.',
				"27" => '27 in.',
				"28" => '28 in.(Default)',
				"29" => '29 in.',
				"30" => '30 in.',
				"31" => '31 in.',
				"32" => '32 in.',
			);
			$longSleeve = array(
				"22" => '22 in.',
				"22.5" => '22.5 in.',
				"23" => '23 in.',
				"23.5" => '23.5 in.',
				"24" => '24 in. (Default)',
				"24.5" => '24.5 in.',
				"25" => '25 in.',
				"25.5" => '25.5 in.',
				"26" => '26 in.',
				"26.5" => '26.5 in.',
			);
			$shortSleeve = array(
				"7.5" => '7.5 in.',
				"8" => '8 in.',
				"8.5" => '8.5 in.',
				"9" => '9 in. (Default)',
				"9.5" => '9.5 in.',
				"10" => '10 in.',
				"10.5" => '10.5 in.',
			);
			?>
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			<?php
			switch ($type) {
				case '1':
				case '2':
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'user-measurements-form',
						'enableAjaxValidation'=>false,
					));
					echo $form->hiddenField($model,'umr_type',array('value'=>0));
					echo $form->textFieldRow($model,'umr_name',array('class'=>'span5','maxlength'=>200));
					echo $form->dropDownListRow($model,'umr_size',$sizes,array('class'=>'span5','empty'=>'Select'));
					echo $form->dropDownListRow($model,'umr_fit',array(1 => 'Regular Fit',2 => 'Slim Fit'),array('class'=>'span5','empty' => 'Select'));
					?>
					<div style="clear:both;"></div>
					<?php
					echo Chtml::link('Customize','javascript:void(0);',array('class' => 'btn btn-primary customizestdSize'));
					?>
					<div class="customSTD">						
						<?php
						echo $form->dropDownListRow($model,'umr_collor',$collorSizes, array('class'=>'span5'));
						echo $form->dropDownListRow($model,'umr_shirt_length',$shirtLength,array('class'=>'span5'));
						echo $form->dropDownListRow($model,'umr_long_sleeve',$longSleeve,array('class'=>'span5'));
						echo $form->dropDownListRow($model,'umr_short_sleeve',$shortSleeve,array('class'=>'span5'));
						?>
					</div>
					<?php	
					$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Save',
					));			
					$this->endWidget();				
					break;
				case '3':
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'user-measurements-form',
						'enableAjaxValidation'=>false,
					));
					echo $form->hiddenField($model,'umr_type',array('value'=>1));
					?>
					<div>
						Follow these simple steps to replicate the fit of your best fitting shirt:
					</div>
					<div>	
						<ul>
							<li>Enter and save a profile name (at the bottom of the page). Then you can either continue shopping or checkout.</li>
							<li>Once the payment is processed, you can go to your Order History and click on "Print Shipping Label" button under the current shirt order. This shipping label will also be sent to you through email.</li>
							<li>Print and affix the shipping label on the package containing your best fit shirt and courier it to us. Be sure to include: Your Name, Phone Number, Email Address and Return Address.</li>
						</ul>
					</div>
					<div>To use this measurement profile, save a profile name:</div>
					<div>
						<?php
						echo $form->textFieldRow($model,'umr_name',array('class'=>'span5','maxlength'=>200));
						?>
					</div>
					<?php
					$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Save',
					));			
					$this->endWidget();	
					break;					
				case '4':
				case '5':
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'user-measurements-form',
						'enableAjaxValidation'=>false,
					));
					echo $form->hiddenField($model,'umr_type',array('value'=>2));
					?>
					<div style="width:30%;float:left;">
						<?php
						echo $form->textFieldRow($model,'umr_collor',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_shoulder',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_chest_half',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_mid_section_half',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_hip_half',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_shirt_length',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_long_sleeve',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_short_sleeve',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_short_sleeve_opening',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_arm_half',array('class'=>'span5','placeholder' => 'inches'));
						echo $form->textFieldRow($model,'umr_cuff',array('class'=>'span5','placeholder' => 'inches'));
						?>
					</div>
					<div style="width:70%;float:left;">
						<div>
							<div>
								<?php
								echo $form->textFieldRow($model,'umr_name',array('class'=>'span5','maxlength'=>200));
								?>
							</div>
							<div style="clear:both;"></div>
			        		<div style="float:left;width:50%;">
			        			<ul class="bxslider">
								  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-a.jpg"></li>
								  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-b.jpg"></li>
								  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-c.jpg"></li>										  
								</ul>
			        		</div>
			        		<div style="float:left;width:50%;">
			        			<iframe width="325" height="250" src="https://www.youtube.com/embed/oup66kOC4Y0" frameborder="0" allowfullscreen></iframe>
			        		</div>
			        		<div style="clear:both;"></div>
			        	</div>
			        	<div>
							<b>Collar:</b> Unbutton the collar and the shirt buttons. Lay the shirt on its front with the collar spread out flat. Pull the collar tight so that curve of the collar is stretched straight. Measure from the center of the button to the center of the button hole. 
			        	</div>
					</div>
					<?php
					$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Save',
					));			
					$this->endWidget();	
					break;
				case '6':	
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'user-measurements-form',
						'enableAjaxValidation'=>false,
					));
					echo $form->hiddenField($model,'umr_type',array('value'=>3));
					?>
					<div id="example-basic">
					    <h3></h3>
					    <section>
					    	<div>
					    		<div>You do not need a tailor, nor do you need a friend's assistance.</div>
								<div>You simply need a measure tape and 10 minutes to finish this guide.</div>
								<div>Get started by entering your height and weight below.</div>
					    	</div>
					    	<div>&nbsp;</div>
					    	<div>
						        <?php
						        $height = array(4=>4,5=>5,6=>6,7=>7,8=>8);
						        $feet = array(0=>0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11);
								echo $form->textFieldRow($model,'umr_name',array('class'=>'span5','maxlength'=>200));
								echo $form->dropDownListRow($model,'umr_height',$height,array('class'=>'span5','empty' => 'Select'));
								echo "Feet";
								echo $form->dropDownListRow($model,'umr_feet',$feet,array('class'=>'span5','empty' => 'Select','label' => false));
								echo "Inches";
								?>
								<div style="clear:both;"></div>
								<?php
								echo $form->textFieldRow($model,'umr_weight',array('class'=>'span5'));
								echo "Kgs";
								?>
							</div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>What type of shirt fit do you prefer?</div>
					    	<?php 
					    	echo $form->hiddenField($model,'umr_fit'); 
					    	$umr_feet_select = '';
					    	if(!empty($model->umr_fit)){
					    		$umr_feet_select = $model->umr_fit;
					    	}
					    	?>
					    	<div>&nbsp;</div>
					    	<div>
						    	<ul class="bodyFits">
						    		<li class="<?php echo ($umr_feet_select==1) ? 'selected' : ''; ?>">
						    			<a href="javascript:void(0);" rel="1">
									        <div>
									        	<div align="center">SLIM</div>
									        	<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/slim-preview.png"></div>
									        	<div>A fit neither skinny nor loose; be prepared for some tightness around the arms.</div>
									        </div>
								        </a>
						        	</li>
						        	<li class="<?php echo ($umr_feet_select==2) ? 'selected' : ''; ?>">
						        		<a href="javascript:void(0);" rel="2">
									        <div>
									        	<div align="center">REGULAR</div>
									        	<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/regular-preview.png"></div>
									        	<div>A balanced fit with some excess fabric for ease of movement, without being baggy.</div>
									        </div>
								        </a>
						        	</li>
						        	<li class="<?php echo ($umr_feet_select==3) ? 'selected' : ''; ?>">
						        		<a href="javascript:void(0);" rel="3">
									        <div>
									        	<div align="center">LOOSE</div>
									        	<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/loose-preview.png"></div>
									        	<div>A relaxed fit for those who value comfort and don't mind some excess fabric.</div>
									        </div>
								        </a>
						        	</li>
						        </ul>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Please select below the option that suits you best</div>
					    	<div>&nbsp;</div>
					        <div>
					        	<div>How would you describe your arms?</div>
					        	<div>
					        		<?php 
					        		echo $form->radioButtonListRow(
					        			$model,'umr_describe_arms',array(
					        				'1'=>'Not muscular',
					        				'2'=>'Slightly muscular',
					        				'3'=>'My arms are muscular'
					        			),
					        			array(
					        				'label' => false
					        			)
					        		); 
					        		?>
					        	</div>
					        	<div>How do you like to wear your shirt?</div>
					        	<div>
					        		<?php 
					        		echo $form->radioButtonListRow(
					        			$model,'umr_wear_shirt',array(
					        				'1'=>'I keep my shirt tucked in at all times',
					        				'2'=>'I keep my shirt tucked out and I prefer a short length',
					        				'3'=>'I keep my shirt tucked out, but I prefer a longer length',
					        				'4'=>'I sometimes tuck in my shirt and sometimes keep it out'
					        			),
					        			array(
					        				'label' => false
					        			)
					        		); 
					        		?>
					        	</div>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>How do you like to wear your short sleeves?</div>
					    	<div>&nbsp;</div>
					        <div>
				        		<?php 
				        		echo $form->radioButtonListRow(
				        			$model,'umr_prefer_wear',array(
				        				'0'=>'I prefer formal short sleeves (Formal short sleeves end closer to the elbow).',
				        				'1'=>'I prefer casual short sleeves (Casual short sleeves end about mid-way between the shoulder and elbow).',
				        				'2'=>'I never wear short sleeves'				        				
				        			),
				        			array(
				        				'label' => false
				        			)
				        		); 
				        		?>
				        	</div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Measure your Stomach.</div>
					    	<div>&nbsp;</div>
					        <div>
					        	<div>
					        		<div style="float:left;width:50%;">
					        			<ul class="bxslider">
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Stomach-a.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Stomach-b.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Stomach-c.jpg"></li>										  
										</ul>
					        		</div>
					        		<div style="float:left;width:50%;">
					        			<iframe width="325" height="250" src="https://www.youtube.com/embed/Xc17iUWwrSw" frameborder="0" allowfullscreen></iframe>
					        		</div>
					        		<div style="clear:both;"></div>
					        	</div>
					        	<div>
					        		Place the measuring tape around the fullest part of your belly, this is usually 1 inch below the belly button. Stand relaxed without sucking your stomach inside. Hold the measuring tape snug to the body without squeezing too tight. Make sure it stays level at the lower part of the back. Note the measurement. 
					        	</div>
					        	<div>
					        		<?php
					        		echo $form->textFieldRow($model,'umr_stomach',array('class'=>'span5'));
					        		echo 'Inches';
					        		?>
					        	</div>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Measure your Hip.</div>
					    	<div>&nbsp;</div>
					        <div>
					        	<div>
					        		<div style="float:left;width:50%;">
					        			<ul class="bxslider">
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Hip-a.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Hip-b.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Hip-c.jpg"></li>										  
										</ul>
					        		</div>
					        		<div style="float:left;width:50%;">
					        			<iframe width="325" height="250" src="https://www.youtube.com/embed/lWZK4eUv1Go" frameborder="0" allowfullscreen></iframe>
					        		</div>
					        		<div style="clear:both;"></div>
					        	</div>
					        	<div>
					        		Empty your pockets before you begin this measurement. Place the measuring tape around the fullest part of your hips. Do not hold the measuring tape too tight and ensure it levels at the back. Now note the measurement. 
					        	</div>
					        	<div>
					        		<?php
					        		echo $form->textFieldRow($model,'umr_hip',array('class'=>'span5'));
					        		echo 'Inches';
					        		?>
					        	</div>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Measure your Chest.</div>
					        <div>
					        	<div>
					        		<div style="float:left;width:50%;">
					        			<ul class="bxslider">
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Chest-a.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Chest-b.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Chest-c.jpg"></li>										  
										</ul>
					        		</div>
					        		<div style="float:left;width:50%;">
					        			<iframe width="325" height="250" src="https://www.youtube.com/embed/FLKrtlSdUX4" frameborder="0" allowfullscreen></iframe>
					        		</div>
					        		<div style="clear:both;"></div>
					        	</div>
					        	<div>
					        		It is quite easy to manage this measurement on your own. Raise your arms. Place the measuring tape around the fullest part of your chest, typically one inch below the armpit. Ensure that the measuring tape is not placed too tight around the chest and levels at the back. Now note the measurement. 
					        	</div>
					        	<div>
					        		<?php 
					        		echo $form->textFieldRow($model,'umr_chest',array('class'=>'span5')); 
					        		echo 'Inches';
					        		?>
					        	</div>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Measure your Collar.</div>
					    	<div>&nbsp;</div>
					    	<div>
					    		From your chest measurement we have estimated your collar size as 11.25 inches. You can proceed with our estimate or measure yourself. However, if you wear a tie we recommend you cross check this measurement.
					    	</div>
					    	<div>&nbsp;</div>
					        <div>
					        	<div>
					        		<div style="float:left;width:50%;">
					        			<ul class="bxslider">
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-a.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-b.jpg"></li>
										  <li><img src="<?php echo Yii::app()->baseUrl; ?>/images/Collar-c.jpg"></li>										  
										</ul>
					        		</div>
					        		<div style="float:left;width:50%;">
					        			<iframe width="325" height="250" src="https://www.youtube.com/embed/oup66kOC4Y0" frameborder="0" allowfullscreen></iframe>
					        		</div>
					        		<div style="clear:both;"></div>
					        	</div>
					        	<div>
									This is the only non-body measurement in this list. For the sake of accuracy, we prefer collar measurement to neck measurement. Take a shirt that fits you well at the collar. To measure the collar, unbutton the collar and the shirt buttons. Spread the collar flat and pull it tight so that curve of the collar is stretched straight. Measure from the center of the button to the center of the button hole.
					        	</div>
					        	<div>
					        		<?php 
					        		echo $form->textFieldRow($model,'umr_collor_measurment',array('class'=>'span5')); 
					        		echo 'Inches';
					        		?>
					        	</div>
					        </div>
					    </section>
					    <h3></h3>
					    <section>
					    	<div>Describe your shoulder structure in comparison to your chest.</div>
					    	<div>&nbsp;</div>
					        <div> 
					        	<?php 
					        	echo $form->hiddenField($model,'umr_shoulder_structure'); 
					        	$umr_shoulder_structure_select = '';
						    	if(!empty($model->umr_shoulder_structure)){
						    		$umr_shoulder_structure_select = $model->umr_shoulder_structure;
						    	}
					        	?>
					        	<ul class="shoulderFit">
					        		<li class="<?php echo ($umr_shoulder_structure_select==1) ? 'selected' : ''; ?>">
					        			<a href="javascript:void(0);" rel="1">
						        			<div align="center">Extremely Narrow</div>
						        			<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/bm-extremly-narrow-preview.png"></div>
						        			<div>Noticed only in overweight men. For such men, readymade shirts droop significantly at the shoulders</div>
					        			</a>
					        		</li>
					        		<li class="<?php echo ($umr_shoulder_structure_select==2) ? 'selected' : ''; ?>">
					        			<a href="javascript:void(0);" rel="2">
						        			<div align="center">Narrow</div>
						        			<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/bm-narrow-preview.png"></div>
						        			<div>Such men have rounded or sloping shoulders and find that readymade shirts droop at their shoulders</div>
					        			</a>
					        		</li>
					        		<li class="<?php echo ($umr_shoulder_structure_select==3) ? 'selected' : ''; ?>">
					        			<a href="javascript:void(0);" rel="3">
						        			<div align="center">Regular</div>
						        			<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/bm-regular-preview.png"></div>
						        			<div>More than 60% of men fall in this category, so don't be surprise if you do too</div>
					        			</a>
					        		</li>
					        		<li class="<?php echo ($umr_shoulder_structure_select==4) ? 'selected' : ''; ?>">
					        			<a href="javascript:void(0);" rel="4">
						        			<div align="center">Broad</div>
						        			<div><img src="<?php echo Yii::app()->baseUrl; ?>/images/bm-broad-preview.png"></div>
						        			<div>Noticed in skinny men with a wide shoulder frame and in men with very muscular shoulders</div>
					        			</a>
					        		</li>
					        	</ul>
					        </div>
					    </section>
					</div>
					<?php
					$this->endWidget();	
					break;				
			}
			?>	
		</div> 		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function($) {
		$("#example-basic").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slideLeft",
		    autoFocus: true,
		    onFinished: function (event, currentIndex) { 
		    	return $('#user-measurements-form').submit();
		    },
		    onFinishing: function (event, currentIndex) { 
		    	return true; 
		    },
		    labels: {
		    	finish: "Save",
		    }
		});	
		$('.bxslider').bxSlider({
			auto:true,
			autoStart:true
		});
		/*$('.bxsliderHoz').bxSlider({
			auto:true,
			autoStart:true,
			mode: 'horizontal',
		});*/
		$('.customizestdSize').click(function(event) {
			if($('#UserMeasurements_umr_size').val()==''){
				alert('Please select size.');
				return false;
			}
			if($('#UserMeasurements_umr_fit').val()==''){
				alert('Please select fit.');
				return false;
			}
			$('.customSTD').show();
		});

		$('.bodyFits a').click(function(event) {
			var val = $(this).attr('rel');
			$('.bodyFits li').removeClass('selected');
			$(this).parent().addClass('selected');
			$(this).parent().parent().parent().parent().find('#UserMeasurements_umr_fit').val(val);
		});
		$('.shoulderFit a').click(function(event) {
			var val = $(this).attr('rel');
			$('.shoulderFit li').removeClass('selected');
			$(this).parent().addClass('selected');
			$(this).parent().parent().parent().find('#UserMeasurements_umr_shoulder_structure').val(val);
		});

		$('#user-measurements-form').submit(function(event) {
			event.preventDefault();
			var data = $(this).serialize();
			var url = $(this).attr('action');
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: data,
				success:function(data) {
					if(data){
						if(data.error==0){
							alert(data.msg);
							var hash = location.hash;
							if(hash=='#measurementModal1' || hash=='#measurementModal3' || hash=='#measurementModal4' || hash=='#measurementModal6'){
								location.hash = 'cartModal';								
						    }
							location.reload();							
						}
					}
				}
			});			
		});
	});
</script>