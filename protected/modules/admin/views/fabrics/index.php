<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Categories</div>
                <div style="float:right">
                	<?php
                	echo CHtml::link('Add Fabrics',array('/admin/fabrics/create'),array('class' => 'btn btn-primary'));
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
							'name'=>'fab_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->fab_name)'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{assignbutton} | {uploadcustomizeimages} | {update} | {delete}',
							'buttons'=>array(
								'assignbutton' => array(
									'label'=>'Assign Buttons',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/fabrics/addbuttons", array("id"=>$data->fab_id))',
								),
								'uploadcustomizeimages'=>array(
									'label'=>'Upload Customize Image',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/fabrics/uploadcustomizeimages", array("id"=>$data->fab_id))',	
									//'visible' => '($data->fab_id!=0) ? true : false'
								),
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/fabrics/update", array("id"=>$data->fab_id))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/fabrics/delete", array("id"=>$data->fab_id))',
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
