<?php
$cs = Yii::app()->clientScript;		
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/upload.min.css');      
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/stylo_se_min.css');

$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/upload.min.js');
// For the shirt editor preview
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lang/se_en.js');
// $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/indianStyloSEApi.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/StyloSEMin.js');
// For the trouser editor preview
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lang/te_en.js');
// $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/indianStyloSEApi.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/StyloTEMin.js');

$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js');
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Upload Customized Images
            </div>
            <div class="panel-body">
	            <div class="col-lg-6">
		            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'fabrics-form',
						'enableAjaxValidation'=>false,		
						'htmlOptions' => array('enctype' => 'multipart/form-data'),	
					)); ?>
					<?php
					if(!empty($model->fab_for)){
						if($model->fab_for==1){
							//Shirt
							$fabImageCustOptions = array(
								1=>'Sleeve',2=>'Collar',3=>'Cuff',4=>'Placket',5=>'Pocket',6=>'Back Detail',7=>'Bottom Cut',8=>'Front Yoke'
							);
							?>
							<label>Customize Options</label>
							<?php echo $form->dropdownListRow($model,'fab_imagecust_option',$fabImageCustOptions,array('empty' => 'Select Option','label' => false,'class' => 'form-control')); ?>
							<div>&nbsp;</div>
							<label>Customize Sub-Options</label>
							<?php echo $form->dropdownListRow($model,'fab_imagecust_suboption',array(),array('label' => false,'class' => 'form-control')); ?>
							<div>&nbsp;</div>
							<label>Image</label>
							<?php //echo $form->fileFieldRow($model,'fab_image',array('label' => false, 'class' => 'form-control')); ?>
							<div id="fileuploader" style="width:100%;">Upload</div>
							<div>&nbsp;</div>
						<?php }else if($model->fab_for==2){
							//Trouser
							$fabImageCustOptions = array(
								1=>'Main Trouser',2=>'Pleated',3=>'Side Pocket',4=>'Back Trouser and Pocket',5=>'Bottom Style',6=>'Trouser Lining');
							?>
							<label>Customize Options</label>
							<?php echo $form->dropdownListRow($model,'fab_imagecust_option',$fabImageCustOptions,array('empty' => 'Select Option','label' => false,'class' => 'form-control')); ?>
							<div>&nbsp;</div>
							<label>Customize Sub-Options</label>
							<?php echo $form->dropdownListRow($model,'fab_imagecust_suboption',array(),array('label' => false,'class' => 'form-control')); ?>
							<div>&nbsp;</div>
							<label>Image</label>
							<?php //echo $form->fileFieldRow($model,'fab_image',array('label' => false, 'class' => 'form-control')); ?>
							<div id="fileuploader" style="width:100%;">Upload</div>
							<div>&nbsp;</div>
						<?php }else if($model->fab_for==2){
							//Blazer	
						}
						?>
						<div id="uploadedImage"></div>
						<div>&nbsp;</div>
						<div class="form-actions">
							<?php
	                        $this->widget('bootstrap.widgets.TbButton', array(
	                              'buttonType'=>'button',
	                              'type'=>'primary',
	                              'label'=>'Cancel',
	                              'htmlOptions' => array('id' => 'cancelBtn')
	                        )); 
	                        ?>
						</div>
						<?php
					}else{
						?>
						This Fabric not for upload customized images.
						<?php
					}
					?>
					<?php $this->endWidget(); ?>
				</div>
				<div class="col-lg-6">
					// editor window
					<div class="box3 f_left clearfix">
			            <div class="prc"><button onclick="refreshImages();">Refresh</button></div>
			            <div class="main_inr_box_new">
			                <div id="product_editor" class="editmyshirt" style="border:1px solid #ccc;"></div>
			            </div>            
			        </div>

				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var indianStyloEditorJson = {fabricId:<?php echo $fabricId;?>,buttonId:1};
	$(document).ready(function(){
		var fab_for = '<?php echo $model->fab_for; ?>';
		var fabid = '<?php echo $model->fab_id; ?>';
		$("#fileuploader").uploadFile({ //	
			url:"<?php echo Yii::app()->baseUrl; ?>/admin/fabrics/uploadimages",
			formData:{YII_CSRF_TOKEN:'<?php echo Yii::app()->request->csrfToken; ?>'},
			dynamicFormData: function(){
				var data ={ option:$('#Fabrics_fab_imagecust_option').val(),suboption:$('#Fabrics_fab_imagecust_suboption').val(),fab_for:fab_for,fabid:fabid }
				return data;
			},
			multiple:false,
			fileName:'myfile',
			//maxFileCount:1,
			allowedTypes:"png",
			returnType:"json",
			uploadErrorStr:"Please select mandotary fileds.",
			onSubmit:function(files){
				 if($('#Fabrics_fab_imagecust_option').val()==''){
				 	alert('Please select atleast any one customize option.');
				 	return false;
				 }
				 if($('#Fabrics_fab_imagecust_suboption').val()==''){
				 	alert('Please select atleast any one customize suboption.');
				 	return false;
				 }
				 if(fab_for==''){
				 	alert('Something went wrong. Please contact to web administrator.');
				 	return false;
				 }
				 if(fabid==''){
				 	alert('Something went wrong. Please contact to web administrator.');
				 	return false;
				 }
			},
			onSuccess:function(files,data,xhr){
				if(data){
					if(data.error==1){
						alert(data.msg);
					}else{
						$("#uploadedImage").html('<img src="<?php echo Yii::app()->baseUrl; ?>/storage/'+data.file+'" width="150">');				
						refreshImages();
					}	
				}
			},
			onError: function(files,status,errMsg){
				alert('Error in file upload.');				
			}			
		});

		$('#Fabrics_fab_imagecust_option').change(function(){
			var val = $(this).val();
			var html = '<option value="">Selete Suboptions</option>';
			if(fab_for==1){
				// Fro Shirt
	        	switch(val){
					case '1':
						html += '<option value="1">Short</option>';
						html += '<option value="2">Long</option>';
						html += '<option value="3">Rolled Up</option>';
						break;
					case '2':
						html += '<option value="1">Bottom Down</option>';
						html += '<option value="2">Classic</option>';
						html += '<option value="3">Short Spread</option>';
						html += '<option value="4">Spread</option>';
						html += '<option value="5">Tall Spread</option>';
						html += '<option value="6">Chinese</option>';
						break;
					case '3':
						html += '<option value="1">Left Single Button</option>';
						html += '<option value="2">Right Single Button</option>';
						html += '<option value="3">Left Double Button</option>';
						html += '<option value="4">Right Double Button</option>';
						html += '<option value="5">Left French Cuff</option>';
						html += '<option value="6">Right French Cuff</option>';
						break;
					case '4':
						html += '<option value="1">American</option>';
						html += '<option value="2">French</option>';
						html += '<option value="3">Hidden</option>';
						break;
					case '5':
						html += '<option value="1">Left Round</option>';
						html += '<option value="2">Right Round</option>';
						html += '<option value="3">Left Square</option>';
						html += '<option value="4">Right Square</option>';
						html += '<option value="5">Left Angled</option>';
						html += '<option value="6">Right Angled</option>';
						html += '<option value="7">Left Vshape</option>';
						html += '<option value="8">Right Vshape</option>';
						html += '<option value="9">Left Flap</option>';
						html += '<option value="10">Right Flap</option>';
						break;
					case '6':
						html += '<option value="1">No Pleats</option>';
						html += '<option value="2">Box Pleat</option>';
						html += '<option value="3">Side Pleat</option>';
						html += '<option value="4">Back Yoke</option>';
						break;
					case '7':
						html += '<option value="1">Round</option>';
						html += '<option value="2">Straight</option>';
						break;
					case '8':
						html += '<option value="1">Center Front</option>';
						html += '<option value="2">Side Front</option>';					
						break;
				}
	        }else if(fab_for==2){
	        	// Fro Trouser
	        	switch(val){
					case '1':
						html += '<option value="1">Trouser</option>';
						break;
					case '2':
						html += '<option value="1">Single Pleated</option>';
						html += '<option value="2">Double Pleated</option>';
						html += '<option value="3">Flat Front Pleated</option>';
						break;
					case '3':
						html += '<option value="1">Slant Pocket</option>';
						html += '<option value="2">Straight Pocket</option>';
						break;
					case '4':
						html += '<option value="1">Flap Left</option>';
						html += '<option value="2">Flap Right</option>';
						html += '<option value="3">Double Welp Pocket Left</option>';
						html += '<option value="4">Double Welp Pocket Right</option>';
						html += '<option value="5">Back Side Trouser</option>';
						break;
					case '5':
						html += '<option value="1">Straight Hem</option>';
						html += '<option value="2">Shoe cut</option>';
						html += '<option value="3">Turn Up</option>';
						break;
					case '6':
						html += '<option value="1">No linin</option>';
						html += '<option value="2">Half front Linin</option>';
						html += '<option value="3">Half front and Back Lining</option>';
						break;
				}
	        }
			$('#Fabrics_fab_imagecust_suboption').html(html);
			$("#uploadedImage").html('');
		});
		
		$('#Fabrics_fab_imagecust_suboption').change(function(){
			var val = $(this).val();
			var url = '<?php echo Yii::app()->baseUrl; ?>/admin/fabrics/imageexist';
			$.ajax({
			  	method: "GET",
			  	url: url,
			  	data:{ option:$('#Fabrics_fab_imagecust_option').val(),suboption:$('#Fabrics_fab_imagecust_suboption').val(),fab_for:fab_for,fabid:fabid },
			  	dataType: "json",
			  	success:function(data){
			  		if(data.file){
			  			$("#uploadedImage").html('<img src="<?php echo Yii::app()->baseUrl; ?>/storage/'+data.file+'" width="150">');					  		
					}
			  	},			  
			});
		});

		$('#cancelBtn').click(function(){
            window.location = '<?php echo Yii::app()->baseUrl; ?>/admin/fabrics';
        });

        // INITIALIZE THE EDITOR
        // var indianStyloEditorJson = {fabricId:<?php echo $fabricId;?>,buttonId:1};
        if(fab_for==1){
        	indianStyloEditorObject = $("#product_editor").indianStyloSE(indianStyloEditorJson);
        }else if(fab_for==2){
        	indianStyloEditorObject = $("#product_editor").indianStyloTE(indianStyloEditorJson);
        }
        // $("#tabs").tabs({
            // activate: function(event,ui){ console.log(ui.newTab.index()); if(ui.newTab.index()==6){ indianStyloSEObj.showRear(); }else{ indianStyloSEObj.showFront(); } }
        // });
	});

	/*function updateElements(elem,newobj){
      switch(elem){
        case 1:
          indianStyloSEObj.updateFabric(newobj);
        break;
        case 2:
          indianStyloSEObj.updateSleeves(newobj);
        break;
        case 3:
          indianStyloSEObj.updateCollar(newobj);
        break;
        case 4:
          indianStyloSEObj.updateFrontShirt(newobj);
        break;
        case 5:
          indianStyloSEObj.updatePocket(newobj);
        break;
        case 6:
          indianStyloSEObj.updatePocketVisibility(newobj);
        break;
        case 7:
          indianStyloSEObj.updateCuff(newobj);
        break;
        case 8:
          indianStyloSEObj.updateBackPleats(newobj);
        break;
        case 10:
          indianStyloSEObj.updatePlacket(newobj);
        break;
        case 11:
          indianStyloSEObj.updateButton(newobj);
        break;
      }
    }*/
    function refreshImages(){
    	indianStyloEditorObject.refreshFabricImages();
    }
</script>