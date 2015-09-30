<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Cmspage 
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
							'name'=>'c_pagename',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->c_pagename)'
						),
						array(
							'name'=>'c_title',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->c_title)'
						),
						/*array(
							'name'=>'c_subtitle',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->c_subtitle)'
						),*/																
						array(
							'name'=>'c_modified',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->c_modified)',
							'filter'=>false
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/cmspage/edit", array("id"=>$data->c_id))',
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
        