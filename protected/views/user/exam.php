<div class="totalscore">
	Total Score: <span id="score">0</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	[<a href="<?php echo Yii::app()->baseUrl; ?>/dashboard">Back</a>]
</div>
<div class="exam-cnt">
	<?php
	$this->widget('zii.widgets.CListView', array(
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_exam',       
	));
	?>
</div>