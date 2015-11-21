<div class="exam-cnt-inner">
	<div>
		<h2>Exam: <?php echo $data->qatExams->ex_title; ?></h2>
	</div>
	<div><h3><?php echo $data->qt_name; ?></h3></div>
	<div>
		<?php
		if(!empty($data->qoptQat)){
			foreach ($data->qoptQat as $qtoKey => $qtoArr) {
				?>
				<div><input type="radio" name="qtoname" value="<?php echo $qtoArr->qto_id; ?>" qid=<?php echo $data->qt_id; ?>>&nbsp;<?php echo $qtoArr->qto_name; ?></div>
				<?php
			}
		}		
		?>
	</div>
</div>