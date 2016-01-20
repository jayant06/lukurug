<div class="examCnt">
	<h3>Exams List</h3>
	<?php
	$this->widget('zii.widgets.CListView', array(
	    'dataProvider'=>$examDataProvider,
	    'itemView'=>'_examdashboard',  
	    'summaryText'=>'', 
	    'id' => 'examView', 
	));
	?>
	<div style="clear:both;">&nbsp;</div>
</div>
