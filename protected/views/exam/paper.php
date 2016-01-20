<div align="center">
	<h2>Exam: <?php echo $exams->ex_title; ?></h2>
</div>
<div class="totalscore">
	<div style="float:left; margin-left:10px;">
		Total Question Pending: <?php echo count($questionsCount) - count($answersCount); ?>
	</div>
	<div style="float:left; margin-left:10px;">
		Total Question Attended: <span id="qattended"><?php echo count($answersCount); ?></span>
	</div>	
</div>
<div style="clear:both;"></div>
<div style="float:right;font-weight:bold;margin-right:5%;text-align:right;">
	<div>Total Time: <?php echo $exams->ex_duration; ?></div>
	<div class="countdown">
		<span>Remaining Time: </span>
		<span id="spanCountdown" countdown="<?php echo $startTime; ?>"></span>
	</div>
</div>
<div class="exam-cnt">
	<?php
	$this->widget('zii.widgets.CListView', array(
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_exam',  
	    'summaryText'=>'', 
	    'id' => 'questionView',
	    'viewData' => array('answers' => $answers) 
	));
	?>
</div>
<div style="clear:both;"></div>
<?php if(!empty($dataProvider)){ ?>
	<div align="center">
		<input type="button" name="finishExam" id="finishExam" value="Finish Exam" class="finishExamBtn">
	</div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.finishExamBtn').click(function(){
			var url = '<?php echo Yii::app()->baseUrl; ?>/user/finishexam';
			var examId = '<?php echo $examId; ?>';
			$.ajax({
				type:'POST',
				url:url,
				data:{examId:examId},
				dataType:'JSON',
				success:function(data){
					if(data){
						if(data.error==1){
							alert(data.msg);
						}else{
							window.location="<?php echo Yii::app()->baseUrl; ?>/user/dashboard";
						}						
					}
				}
			});
		});

		var countDownVal = $("#spanCountdown").attr('countdown');
		$("#spanCountdown")
		   .countdown(countDownVal, function(event) {
		     $(this).text(
		       event.strftime('%H:%M:%S')
		     );
		});
	});
</script>