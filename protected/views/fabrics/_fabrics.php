<li class="<?php echo ($id==$data->fab_id) ? 'selected' : ''; ?>"> 
	<a href="<?php echo Yii::app()->baseUrl; ?>/fabrics/view?id=<?php echo $data->fab_id; ?>&type=<?php echo $data->fab_for; ?>" class="fabricClick" id="<?php echo $data->fab_id; ?>">
		<input type="hidden" name="fabric" rel="<?php echo $data->fab_name; ?>" fab_id="<?php echo $data->fab_id; ?>">
		<div>
			<img src="<?php echo Yii::app()->baseUrl; ?>/storage/fabrics/<?php echo $data->fab_image; ?>">
		</div>
		<div>
			<b>
			<?php
			echo $data->fab_name;
			?>
			</b>
		</div>
		<div>
			<b>
			₹
			<?php
			echo $data->fab_price;
			?>
			</b>
		</div>
	</a>
</li>