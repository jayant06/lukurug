<?php 
$question_no = 1; $index =0; $answer_options_array = array();
foreach ($dataProvider as $key => $value) {
	if($question_no==5){
		$question_no=1;
	}
	if($question_no==1){
		$index++;
		$this->questions_json[] = array('key_id'=>$index,'question_id'=>$value['ua_question_id'],'answer_status'=>$value['ua_answer_status']);
		
		$answer_options_array[] = array('ua_option_id'=>$value['ua_option_id'],'qto_id'=>$value['qto_id'],'ua_question_id'=>$value['ua_question_id']);
		?>
		<div id="question_<?php echo $index?>" user-que-ans="<?php echo $index.'_'.$value['ua_id'].'_'.$value['ua_question_id'].'_'.$value['ua_answer_status'];?>" class="question_div <?php if($index==1){ echo 'active_question'; }?>">
			<div class="question">
				<div class="question_number">Q.<?php echo $index;?>:</div>
				<?php if($value['qt_type']==1){?>	
				<div class="question_body"><?php print_r($value['qt_name']);?></div>
				<?php }else if($value['qt_type']==2){?>
				<div class="question_body"><img class="img-responsive" src="<?php echo Yii::app()->baseUrl.'/storage/questions/'.$value['qt_image'];?>" border="0"></div>
				<?php }?>
			</div>
			<?php if($value['qt_type']==1){?>
			<div class="answer_options">
				<ol type="A">
					<li><?php echo $value['qto_name'];?></li>
			<?php }?>
		<?php
	}else if($question_no>=2 && $question_no<=4){
		if($value['qt_type']==1){
			?><li><?php echo $value['qto_name'];?></li><?php
		}
		$answer_options_array[] = array('ua_option_id'=>$value['ua_option_id'],'qto_id'=>$value['qto_id'],'ua_question_id'=>$value['ua_question_id']);
	}

	if($question_no==4){
		?>
			<?php if($value['qt_type']==1){?>
				</ol>
			</div>
			<?php }?>
			<div class="default_answer_option" style="clear:both;">
			<?php 
			$optionval = 'A';
			foreach ($answer_options_array as $key => $answervalue) {
				$checked = '';
				// print_r($answervalue); exit;
				if($answervalue['ua_option_id']==$answervalue['qto_id']){
					$checked = 'checked="checked"';
				}
				?><label><?php echo $optionval;?> <input <?php echo $checked;?> type="radio" value="<?php echo $answervalue['qto_id'];?>" name="option_<?php echo $answervalue['ua_question_id']?>"></label>&nbsp;&nbsp;<?php
				$optionval++;
			}
			?>
			</div>
		</div>
		<?php
		$answer_options_array = array();
	}
	$question_no++;
}
?>
		