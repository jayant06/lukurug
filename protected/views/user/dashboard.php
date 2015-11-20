<style type="text/css">
.col-md-12{
	width: 100%;
	margin: 10px;
	float: left;
}	
.col-md-3{
	width: 20%;
	float: left;
}
.col-md-8{
	width: 70%;
	float: left;
}
.col-md-1{
	width: 10%;
	float: left;
}
</style>
<h1>Gurukul Dashboard</h1>

<div class="col-md-12">
	<?php
	if(!empty($modelExams)){
		foreach ($modelExams as $exKey => $exArr) {
			?>
			<div class="col-md-3"><?php echo $exArr->ex_title; ?></div>
			<div class="col-md-8"><?php echo $exArr->ex_details; ?></div>
			<div class="col-md-1"><a href="<?php echo Yii::app()->baseUrl; ?>/user/exam/<?php echo $exArr->ex_id; ?>">View</a></div>
			<?php
		}
	}
	?>
</div>