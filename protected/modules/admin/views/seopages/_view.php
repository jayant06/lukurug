<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sep_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sep_id),array('view','id'=>$data->sep_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sep_page_name')); ?>:</b>
	<?php echo CHtml::encode($data->sep_page_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sep_page_title')); ?>:</b>
	<?php echo CHtml::encode($data->sep_page_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sep_page_keyword')); ?>:</b>
	<?php echo CHtml::encode($data->sep_page_keyword); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sep_page_meta_desc')); ?>:</b>
	<?php echo CHtml::encode($data->sep_page_meta_desc); ?>
	<br />


</div>