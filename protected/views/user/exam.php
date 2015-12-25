<div class="totalscore">
	<div style="float:left; margin-left:10px;">
		Total Question: <?php echo count($questionsCount); ?>
	</div>
	<div style="float:left; margin-left:10px;">
		Total Question Attended: <span id="qattended"><?php echo count($answersCount); ?></span>
	</div>
	<div style="float:left; margin-left:10px;">
		Total Score: 
		<span id="score">
			<?php 
			echo $totalScore;
			?>
		</span>
	</div>
	&nbsp;&nbsp;&nbsp;&nbsp;
	[<a href="<?php echo Yii::app()->baseUrl; ?>/dashboard">Back</a>]
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
<div align="center">
	<input type="button" name="finishExam" id="finishExam" value="Finish Exam" class="finishExamBtn">
</div>
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
	});
</script>