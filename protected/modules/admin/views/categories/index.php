<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Courses</div>
                <div style="float:right">
                	<?php
                	echo CHtml::link('Add Course',array('/admin/categories/create'),array('class' => 'btn btn-primary'));
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
							'name'=>'cat_code',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->cat_code)'
						),
						array(
							'name'=>'cat_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->cat_name)'
						),
						array(
							'name'=>'cat_parent_id',
							'type'=>'raw',
							'filter' => false,
							'value'=>'(!empty($data->courseParent->cat_name)) ? CHtml::encode($data->courseParent->cat_name) : "----"'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update} | {delete}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/categories/update", array("id"=>$data->cat_id))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/categories/delete", array("id"=>$data->cat_id))',
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
