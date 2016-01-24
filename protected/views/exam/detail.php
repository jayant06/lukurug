<div class="row">
	<div class="col-sm-12 col-md-6 col-md-offset-3" >
		<div class="panel panel-primary">
			<div class="panel-heading" align="center">
			  <h3 class="panel-title">Result</h3>
			</div>
			<div class="panel-body">

				<div><h3>Result For: <?php echo ucwords($statistics['ex_title']); ?></h3></div>
				<div class="viewExamsCnt">
					<div align="right">[<a href="<?php echo Yii::app()->baseUrl; ?>/exam/attempted">Back</a>]</div>
					<div>&nbsp;</div>
					<div class="viewExams">Total Questions: <?php echo $statistics['ue_total_question']; ?></div>
					<div class="viewExams">Total Attempt: <?php echo $statistics['ue_total_submitted']; ?></div>
					<div class="viewExams">Total Correct: <?php echo $statistics['ue_total_marks']; ?></div>
					<div class="viewExams">Total Incorrect: <?php echo $statistics['ue_total_submitted'] - $statistics['ue_total_marks']; ?></div>	
				</div>
			</div>
		</div>
	</div>
</div>