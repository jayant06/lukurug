<div><h3><?php echo $examDetail->ex_title; ?></h3></div>
<div class="viewExamsCnt">
	<div align="right">[<a href="<?php echo Yii::app()->baseUrl; ?>/user/dashboard">Back</a>]</div>
	<div>&nbsp;</div>
	<div class="viewExams">Total Questions: <?php echo count($questions); ?></div>
	<div class="viewExams">Total Attempt: <?php echo count($answers); ?></div>
	<div class="viewExams">Total Correct: <?php echo $totalScore; ?></div>
	<div class="viewExams">Total Incorrect: <?php echo count($questions) - $totalScore; ?></div>	
</div>