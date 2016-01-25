<div class="col-sm-12 col-md-6 col-md-offset-3" >
	<div class="panel panel-primary">
		<div class="panel-heading" align="center">
		  <h3 class="panel-title">Profile</h3>
		</div>
		<div class="panel-body">
			<div class="span12">
	        	<div class="col-lg-2 bold">Email:</div><div class="col-lg-10"><?php echo $model->u_email;?></div>
	        	<div class="col-lg-2 bold">First Name:</div><div class="col-lg-10"><?php echo $model->u_first_name;?></div>
	        	<div class="col-lg-2 bold">Last Name:</div><div class="col-lg-10"><?php echo $model->u_last_name;?></div>
	        	<div class="col-lg-2 bold">Gender:</div><div class="col-lg-10"><?php echo ($model->u_gender==2)? 'Female' : 'Male';?></div>
	        	<div class="col-lg-2 bold">Image:</div><div class="col-lg-10"><img src="<?php echo Yii::app()->baseUrl; ?>/storage/users/<?php echo $model->u_image; ?>" width="100"></div>
	        	<div class="col-lg-2 bold">Today Exam Code:</div><div class="col-lg-10"><?php echo '';?></div>
			</div>
		</div>
	</div>
</div>