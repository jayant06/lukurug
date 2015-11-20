<div>
	<?php
	if(!empty($questionData)){
		foreach ($questionData as $qtKey => $qtArr) {
			?>
			<div class="col-md-3"><?php echo $qtArr->qt_name; ?></div>
			<?php
			if(!empty($qtArr->qoptQat)){
				foreach ($qtArr->qoptQat as $qtoKey => $qtoArr) {
					?>
					<div><input type="radio" value="<?php echo $qtoArr->qto_id; ?>">&nbsp;<?php echo $qtoArr->qto_name; ?></div>
					<?php
				}
			}			
		}
	}
	?>
</div>