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
            <div id="alert-message" class="custom-error-success">566 dsdfda</div>
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
							'name'=>'ex_status',
							'type'=>'raw',
							'value'=> '$data->status',
							'filter'=>false,
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
<?php
$url = $this->createUrl('/admin/exams/status');
Yii::app()->clientScript->registerScript('initStatus',
    "$('select.status').on('change',function() {
        el = $(this);
        $.ajax({
			url: '$url',
			data: {status: el.val(), ex_id: el.data('id')},
			type: 'POST',
			success: function(data){
				$('#alert-message').html('Status updated successfully...');	
				$('#alert-message').css('visibility','visible');
				setTimeout(function(){ $('#alert-message').html(''); $('#alert-message').css('visibility','hidden'); },5000);
			}
		});
    });",
    CClientScript::POS_READY
);
?>
