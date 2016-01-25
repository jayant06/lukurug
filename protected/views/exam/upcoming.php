<div align="center" class="row">
	<div class="col-sm-12"> <!-- col-md-4 col-md-offset-4 -->
    	<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Exams List</h3>
      		</div>
      		<div class="panel-body" align="left">
				<?php
				$this->widget('zii.widgets.CListView', array(
				    'dataProvider'=>$examDataProvider,
				    'itemView'=>'_examdashboard',  
				    'summaryText'=>'', 
				    'id' => 'examView', 
				));
				?>
			</div>
		</div>
	</div>
</div>
