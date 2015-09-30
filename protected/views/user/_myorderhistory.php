<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">Orders</div>
                <div style="clear:both;"></div>
            </div>
            <div class="panel-body">                 
	          	<?php
	            $this->widget('bootstrap.widgets.TbGridView', array(
	                'type'=>'bordered striped',
	                'dataProvider' => $orderModel->search(),                           
	                'template'=>"{summary}{items}{pager}",
	                'filter'=>$orderModel,
	                'columns'=>array(
						array(
							'name'=>'cart_orderno',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->cart_orderno)'
						),
						array(
							'name'=>'cart_payment_status',
							'type'=>'raw',
							'filter' => false,
							'value'=>'($data->cart_payment_status==0) ? "Not checkout" : (($data->cart_payment_status==1) ? "Checkout" : (($data->cart_payment_status==2) ? "Success" : "Cancel"))'
						),
						array(
							'name'=>'cart_order_status',
							'type'=>'raw',
							'filter' => false,
							'value'=>'($data->cart_order_status==0) ? "Pending" : (($data->cart_order_status==1) ? "Under Process" : (($data->cart_order_status==2) ? "Deliver" : "Completed"))'
						),
						array(
							'name'=>'cart_created',
							'type'=>'raw',
							'filter' => false,
							'value'=>'CHtml::encode($data->cart_created)'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{view}',
							'buttons'=>array(
								'view'=>array(
									'label'=>'View',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/products/vieworders", array("id"=>$data->cart_id))',
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
