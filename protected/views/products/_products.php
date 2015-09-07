<li>
	<a href="<?php echo Yii::app()->baseUrl; ?>/products/<?php echo $data->itm_slug; ?>">
		<div>
			<img src="<?php echo Yii::app()->baseUrl; ?>/storage/products/<?php echo $data->itm_photo; ?>" style="height:250px;">
		</div>
		<div>
			<b>
			<?php
			echo $data->itm_name;
			?>
			</b>
		</div>
		<div>
			<b>
			₹
			<?php
			echo $data->itm_price;
			?>
			</b>
		</div>
	</a>
</li>