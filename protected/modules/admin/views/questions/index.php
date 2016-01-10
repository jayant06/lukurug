<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Questions</div>
                <div style="float:right">
                	<?php
                	echo CHtml::link('Add Question',array('/admin/questions/create'),array('class' => 'btn btn-primary'));
                	?>
                </div>
                <div style="float:right;padding-right:10px;">
                	<?php
                	echo CHtml::link('Import Questions','javascript:void(0);',array('class' => 'btn btn-primary showImportCnt'));
                	?>
                </div>
                <div style="float:right;padding-right:10px;">
                	<?php
                	echo CHtml::link('Download sample excel',array('/storage/excel/samplequestion.xls'),array('class' => 'btn btn-primary'));
                	?>
                </div>
                <div style="clear:both;">&nbsp;</div>
                <div class="excelImportCnt">                	
                	<?php
                	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  						'id'=>'uploadExcelFile',
 						'enableAjaxValidation'=>false,
  						'htmlOptions' => array('enctype' => 'multipart/form-data'),	
  					));
	                	$examsData = Exams::model()->findAll();
						$exams = CHtml::listData($examsData,'ex_id','ex_title');
	                	?>
	                	<div style="float:left;margin-right:5%;">
		                	<div>Select Exam</div>
		                	<div>
			                	<select name="exam_select" id="exam_select">
			                		<?php
			                		if(!empty($exams)){
			                			foreach ($exams as $examid => $examname) {
			                				?>
			                				<option value="<?php echo $examid; ?>"><?php echo $examname; ?></option>
			                				<?php
			                			}
			                		}
			                		?>                		
			                	</select>
		                	</div>
	                	</div>
	                	<div style="float:left;margin-right:5%;">
		                	<div>Upload excel file</div>
		                	<div>
		                		<input type="file" name="importexcel" id="importexcel">
		                	</div>
	                	</div>
	                	<div style="float:left;">
	                		<input type="submit" name="importquestion" value="Import" class="btn btn-primary">
	                	</div>
	                	<div style="clear:both;"></div>
                	<?php
                	$this->endWidget();
                	?>
                </div>
            </div>
            <div class="panel-body">                 
	          	<?php
	            $this->widget('bootstrap.widgets.TbGridView', array(
	                'type'=>'bordered striped',
	                'dataProvider' => $model->search(),                           
	                'template'=>"{summary}{items}{pager}",
	                'filter'=>$model,
	                'columns'=>array(
						array(
							'name'=>'qt_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->qt_name)'
						),
						array(
							'name'=>'qt_description',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->qt_description)'
						),
						array(
							'name'=>'qt_marks',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->qt_marks)'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update} | {delete}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/questions/update", array("id"=>$data->qt_id))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/questions/delete", array("id"=>$data->qt_id))',
								)
							)
						)
					),
	            ));         
	          	?>
        	</div>
      	</div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.showImportCnt').click(function(){
			if($('.excelImportCnt').is(':hidden')==true){
				$('.excelImportCnt').slideDown('fast');
			}else{
				$('.excelImportCnt').slideUp('fast');
			}
		});
	});
</script>