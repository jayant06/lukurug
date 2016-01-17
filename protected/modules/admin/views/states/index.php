<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">States</div>
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
							'name'=>'st_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->st_name)'
						),
						array(
							'name'=>'st_code',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->st_code)'
						),
					),
	            ));         
	          	?>
        	</div>
      	</div>
    </div>
</div>
