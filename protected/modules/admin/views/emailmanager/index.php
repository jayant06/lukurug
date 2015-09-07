<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Emailmanager
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
							'name'=>'em_title',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->em_title)'
						),
						array(
							'name'=>'em_email_subject',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->em_email_subject)'
						),								
						array(
							'name'=>'em_modified',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->em_modified)',
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
									'url'=>'Yii::app()->createUrl("/admin/emailmanager/edit", array("id"=>$data->em_id))',
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