<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">
                	<?php 
                	if(!empty($model->categoryType)){
                		if($model->categoryType==1)
                			echo 'Main Courses';
                		else if($model->categoryType==2)
                			echo 'Sub Courses';
                		else
                			echo 'Courses';
                	}
                	?>
                </div>
                <div style="float:right;">
                	<?php
                	echo CHtml::link('Add Course',array('/admin/categories/create','type' => $model->categoryType),array('class' => 'btn btn-primary'));
                	?>
                </div>
                <div style="clear:both;"></div>
                <?php
                if($model->categoryType==2 || $model->categoryType==3){
	                ?>
	                <div style="float:left;">
	                	<?php
	                	$criteria=new CDbCriteria;
	                	$criteria->condition = 'cat_parent_id=0 AND cat_parent_type=0';
	                	$criteria->order = 'cat_name';
	                	$categoryData = Categories::model()->findAll($criteria);
						$categories = CHtml::listData($categoryData,'cat_id','cat_name');
	                	?>
	                	<div style="float:left;margin-right:20px;">
	                		Main Course
	                	</div>
	                	<div style="float:left;margin-right:20px;">
	                		<select name="main_f_course_id" id="main_f_course_id">
	                			<option value="">--Select Main Course--</option>
	                			<?php
	                			foreach ($categories as $catId => $catName) {
	                				?>
	                				<option value="<?php echo $catId; ?>"><?php echo $catName; ?></option>
	                				<?php
	                			}
	                			?>
	                		</select>
	                	</div>
	                </div>
	                <?php
	                if($model->categoryType==3){
	                	?>
	                	<div style="float:left;">
		                	<div style="float:left;margin-right:20px;">
		                		Sub Course
		                	</div>
		                	<div style="float:left;margin-right:20px;">
		                		<select name="f_course_id" id="f_course_id"><option value="">--Select Sub Course--</option></select>
		                	</div>
		                </div>
	                	<?php
	                }
	                ?>
	                <div style="float:left;">
	                	<input type="button" id="filter_courses" name="filter_courses" value="Filter">
	                </div>
	                <div style="clear:both;"></div>
	                <?php
            	}
                ?>
            </div>
            <div class="panel-body">                 
	          	<?php
	            $this->widget('bootstrap.widgets.TbGridView', array(
	                'type'=>'bordered striped',
	                'dataProvider' => $model->search(),                           
	                'template'=>"{summary}{items}{pager}",
	                'filter'=>$model,
	                'id' => 'courselist',
	                'columns'=>array(
	                	array(
							'name'=>'cat_code',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->cat_code)'
						),
						array(
							'name'=>'cat_name',
							'type'=>'raw',
							'value'=>'CHtml::encode($data->cat_name)'
						),
						array(
							'name'=>'cat_parent_id',
							'type'=>'raw',
							'filter' => false,
							'value'=>'(!empty($data->courseParent->cat_name)) ? CHtml::encode($data->courseParent->cat_name) : "----"'
						),
						array(
							'header'=>'Action',
							'class'=>'CButtonColumn',																		
							'template'=>'{update} | {delete}',
							'buttons'=>array(
								'update'=>array(
									'label'=>'Edit',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/categories/update", array("id"=>$data->cat_id,"type"=>'.$model->categoryType.'))',
								),
								'delete'=>array(
									'label'=>'Delete',								            
									'imageUrl'=>false,
									'url'=>'Yii::app()->createUrl("/admin/categories/delete", array("id"=>$data->cat_id,"type"=>'.$model->categoryType.'))',
								)
							)
						)
					),
	            ));         
	          	?>
        	</div>
      	</div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#filter_courses').click(function(){
			var courseId = '';
			<?php
			if($model->categoryType==2){
				?>
				courseId = $('#main_f_course_id').val();
				<?php
			}else if($model->categoryType==3){
				?>
				courseId = $('#f_course_id').val();
				<?php
			}
			?>
			//if(courseId!=''){
				$.fn.yiiGridView.update('courselist', {
		           type:'GET',
		           url:$(this).attr('href'),
		           data: {course_id:courseId},
		           success:function(data) {
		            if(data){
			            var html = '<div class="row-fluid"> </div>';
						html += data;
						$('div#page-inner').html(html);
					}
		           }
			  	});
			  	return false;			  	
			//}
		});

		$('#main_f_course_id').change(function(){
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->baseUrl; ?>/admin/categories/subcategories',
				data:{maincatid:$('#main_f_course_id').val()},
				dataType:'JSON',
				success:function(data){
					var html = '<option value="">--Select Sub Course--</option>';
					if(data){
						for(var i=0;i<data.length;i++){
							html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
						}
					}
					$('#f_course_id').html(html);
				}
			});
		});
	});
</script>