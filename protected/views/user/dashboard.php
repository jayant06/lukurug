<h1>Gurukul Dashboard</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
		array(
			'name'=>'ex_title',
			'type'=>'raw',
			'value'=>'CHtml::encode($data->ex_title)'
		),
		array(
			'name'=>'ex_details',
			'type'=>'raw',
			'value'=>'CHtml::encode($data->ex_details)'
		),
		array(
			'header'=>'Action',
			'class'=>'CButtonColumn',																		
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'label'=>'View',								            
					'imageUrl'=>false,
					'url'=>'Yii::app()->createUrl("/user/exam/", array("id"=>$data->ex_id))',
				),				
			)
		)
	),
));
?>