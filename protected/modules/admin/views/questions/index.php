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
