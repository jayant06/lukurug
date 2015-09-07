<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Products</div>
                <div style="float:right">
                	<?php
                	echo CHtml::link('Add Product',array('/admin/items/create'),array('class' => 'btn btn-primary'));
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
							'name'=>'itm_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->itm_name)'
						),
						array(
							'name'=>'itm_price',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->itm_price)'
						),
						array(
							'name'=>'itm_qty',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->itm_qty)'
						),
						array(
							'name'=>'itm_size',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->itm_size)'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update} | {delete}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/items/update", array("id"=>$data->itm_id))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/items/delete", array("id"=>$data->itm_id))',
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
