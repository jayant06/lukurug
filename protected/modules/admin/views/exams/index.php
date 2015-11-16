<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Exams</div>
                <div style="float:right">
                	<?php
                	echo CHtml::link('Add Exams',array('/admin/exams/create'),array('class' => 'btn btn-primary'));
                	?>
                </div>
                <div style="clear:both;"></div>
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
							'name'=>'ex_title',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->ex_title)'
						),
						array(
							'name'=>'ex_start_date_time',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->ex_start_date_time)'
						),
						array(
							'name'=>'ex_end_date_time',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->ex_end_date_time)'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update} | {delete}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/exams/update", array("id"=>$data->ex_id))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/exams/delete", array("id"=>$data->ex_id))',
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
