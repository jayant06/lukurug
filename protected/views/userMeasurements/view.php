<div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title" id="myModalLabel">
	        	<?php
	        	if($type==0)
	        		echo "Standard Size";
	        	else if($type==1)
	        		echo "Send a shirt";
	        	else if($type==2)
	        		echo "Shirt Measurements";
	        	else if($type==3)
	        		echo "Body Measurements";
	        	?>
        	</h4>
      	</div>
      	<div class="modal-body">
			<?php 
			$sizes = array(
				1 => '37 (14.75in)',
				2 => '38 (15in)',
				3 => '39 (15.5in)',
				4 => '40 (15.75in)',
				5 => '41 (16in)',
				6 => '42 (16.5in)',
				7 => '43 (17in)',
				8 => '44 (17.25in)',
				9 => '45 (17.5in)'
			);

			$collorSizes = array(
				"14" => '14 in.',
				"14.5" => '14.5 in.',
				"15" => '15 in. (Default)',
				"15.5" => '15.5 in.',
				"16" => '16 in.',
			);
			$shirtLength = array(
				"24" => '24 in.',
				"25" => '25 in.',
				"26" => '26 in.',
				"27" => '27 in.',
				"28" => '28 in.(Default)',
				"29" => '29 in.',
				"30" => '30 in.',
				"31" => '31 in.',
				"32" => '32 in.',
			);
			$longSleeve = array(
				"22" => '22 in.',
				"22.5" => '22.5 in.',
				"23" => '23 in.',
				"23.5" => '23.5 in.',
				"24" => '24 in. (Default)',
				"24.5" => '24.5 in.',
				"25" => '25 in.',
				"25.5" => '25.5 in.',
				"26" => '26 in.',
				"26.5" => '26.5 in.',
			);
			$shortSleeve = array(
				"7.5" => '7.5 in.',
				"8" => '8 in.',
				"8.5" => '8.5 in.',
				"9" => '9 in. (Default)',
				"9.5" => '9.5 in.',
				"10" => '10 in.',
				"10.5" => '10.5 in.',
			);
			switch ($type) {
				case '0':
					break;
				case '1':
					break;					
				case '2':
					break;
				case '3':	
					break;				
			}
			?>	
		</div> 		
	</div>
</div>