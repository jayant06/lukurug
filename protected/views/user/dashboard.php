<h1>Dashboard</h1>
<div class="examCnt">
	<h3>Completed Exams</h3>
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'summaryText' => '',
	    'filter'=>$model,
	    'columns'=>array(
			array(
				'name'=>'cat_name',
				'type'=>'raw',
				'value'=>'CHtml::encode($data->ueExam->catExams->cat_name)'
			),
			array(
				'name'=>'ex_title',
				'type'=>'raw',
				'value'=>'CHtml::encode($data->ueExam->ex_title)'
			),
			array(
				'name'=>'ex_details',
				'type'=>'raw',
				'value'=>'CHtml::encode($data->ueExam->ex_details)'
			),
			array(
				'name'=>'ex_start_date_time',
				'type'=>'raw',
				'value'=>'date("d-m-Y",strtotime($data->ueExam->ex_start_date_time))'
			),
			array(
				'name'=>'ex_end_date_time',
				'type'=>'raw',
				'value'=>'date("d-m-Y",strtotime($data->ueExam->ex_end_date_time))'
			),
			array(
				'name'=>'ue_exam_start',
				'type'=>'raw',
				'value'=>'date("d-m-Y h:i a",strtotime($data->ue_exam_start))'
			),
			array(
				'header'=>'Action',
				'class'=>'CButtonColumn',																		
				'template'=>'{view}',
				'buttons'=>array(
					'view'=>array(
						'label'=>'View',								            
						'imageUrl'=>false,
						'url'=>'Yii::app()->createUrl("/user/viewexamdetail/", array("id"=>$data->ueExam->ex_id))',
					),				
				)
			)
		),
	));
	?>
</div>
<div>&nbsp;</div>
<div class="examCnt">
	<h3>Pending Exams</h3>
	<?php
	$this->widget('zii.widgets.CListView', array(
	    'dataProvider'=>$examDataProvider,
	    'itemView'=>'_examdashboard',  
	    'summaryText'=>'', 
	    'id' => 'examView', 
	));
	?>
	<div style="clear:both;">&nbsp;</div>
</div>
