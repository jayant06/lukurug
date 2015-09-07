<footer>
	<p>&copy; <?php echo Yii::app()->params['title'];?> <?php echo date('Y');?></p>
</footer>
<?php
$this->renderPartial('/userMeasurements/_measurementModals');
?>
<script type="text/javascript">
	var hash = location.hash;
	var url = '<?php echo Yii::app()->baseUrl; ?>/userMeasurements/create/?type=';
	if(hash=='#measurementModal1'){
		$(hash).modal({
			show:true,
			remote:url+1
		});
    }else if(hash=='#measurementModal3'){
    	$(hash).modal({
			show:true,
			remote:url+3
		});
    }else if(hash=='#measurementModal4'){
    	$(hash).modal({
			show:true,
			remote:url+4
		});
    }else if(hash=='#measurementModal6'){
    	$(hash).modal({
			show:true,
			remote:url+6
		});
    }else if(hash=='#cartModal'){
    	$('#cartModal').modal({
			show:true,
			remote:'<?php echo Yii::app()->baseUrl; ?>/cart/view/'
		});
    }
</script>