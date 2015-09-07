<option value="">Select State</option>
<?php
if(!empty($states)){
	foreach ($states as $key => $value) {
		?>
		<option value="<?php echo $key; ?>"><?php echo  $value; ?></option>
		<?php
	}
}
?>