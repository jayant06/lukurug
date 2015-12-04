<div><h3><?php echo $examDetail->ex_title; ?></h3></div>
<div class="viewExamsCnt">
	<div align="right">[<a href="<?php echo Yii::app()->baseUrl; ?>/user/dashboard">Back</a>]</div>
	<div>&nbsp;</div>
	<div class="viewExams">Total Score: <?php echo $totalScore; ?></div>
	<div class="viewExams">Total Question: <?php echo count($questions); ?></div>
	<div class="viewExams">Total Question Attended: <?php echo count($answers); ?></div>
</div>