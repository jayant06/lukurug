<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                Update Exams
            </div>
            <div class="panel-body">
				<?php echo $this->renderPartial('_update_form', array('model'=>$model,'main_cat_id'=>$main_cat_id,'sub_cat_id'=>$sub_cat_id,'SubCategories'=>$SubCategories)); ?>
			</div>
		</div>
	</div>
</div>