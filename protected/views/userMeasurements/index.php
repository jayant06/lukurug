<?php
$this->breadcrumbs=array(
	'User Measurements',
);

$this->menu=array(
	array('label'=>'Create UserMeasurements','url'=>array('create')),
	array('label'=>'Manage UserMeasurements','url'=>array('admin')),
);
?>

<h1>User Measurements</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
