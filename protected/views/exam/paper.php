<div align="center" class="row">
	<div align="center" class="col-sm-12">
		<div class="exam_title"><?php echo ucwords($exams['ex_title']);?></div>
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<div id="question_button_container"></div>
	</div>
	<div class="col-sm-3" class="statistic_area">
		<p>Total Question Pending: <span id="total_pending_que"><?php echo $statistics['total_not_attempted']+$statistics['total_attempted']+$statistics['total_not_viewed']; ?></span></p>
		<p>Total Question Submitted: <span id="total_submitted_que"><?php echo $statistics['total_submitted']; ?></span></p>
		<p>Total Time: <?php echo $statistics['ex_duration']; ?></p>
		<div class="countdown">
			<span>Remaining Time: </span>
			<span id="spanCountdown" countdown="<?php //echo $startTime; ?>"></span>
			<div id="warning_alert"><img src="<?php echo Yii::app()->baseUrl.'/images/warning-alert.gif';?>" border="0"/></div>
			<div id="red_alert"><img src="<?php echo Yii::app()->baseUrl.'/images/red-alert.gif';?>" border="0"/></div>
		</div>
	</div>
</div>
<div class="row">
	<div align="center" class="col-sm-12" id="processing_bar">
		<span id="processing_bar_msg">Processing....</span> <img src="<?php echo Yii::app()->request->baseUrl.'/images/processing.gif';?>" alt="Processing..." border="0" />
	</div>

	<!-- <div class="alert alert-success">
	  <strong>Success!</strong> Indicates a successful or positive action.
	</div>

	<div class="alert alert-info">
	  <strong>Info!</strong> Indicates a neutral informative change or action.
	</div>
	-->

	<div class="alert alert-warning deactive-alert" id="warning-msg-box"> 
	  <strong>Warning!</strong> Please consider your remaining time, hurry up.
	</div> 
	
	<div class="alert alert-danger deactive-alert" id="alert-msg-box">
	  <strong>Danger!</strong> Only fine minute to finish, submit your pending questions.
	</div>

</div>
<div class="row">
	<div class="col-sm-12 question_area">
		<?php echo $this->renderPartial('_question',array('dataProvider' => $dataProvider),false);?>
	</div>
</div>
<div class="row" style="margin-top:10px;">
	<div class="col-sm-12">
		<div style="float:left;">
			<input type="button" name="finishExam" id="finishExam" onclick="finishExam(1);" value="Finish Exam" class="btn btn-sm btn-danger">
		</div>
		<div style="float:right;">
			<button type="button" class="btn btn-sm btn-primary button-width-70" onclick="moveToQuestion(1);">Previous</button>
			<button type="button" class="btn btn-sm btn-success button-width-70" onclick="saveQuestion(3);">Submit</button>
			<button type="button" class="btn btn-sm btn-success button-width-70" onclick="saveQuestion(2);">Save</button>
			<button type="button" class="btn btn-sm btn-primary button-width-70" onclick="moveToQuestion(0);">Next</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	var initial_question_list_data = <?php echo json_encode($this->questions_json);?>;
	var current_question = 1;
	var current_statistics = <?php echo json_encode($statistics)?>;
	var total_question = current_statistics.total_question;
	var baseurl = "<?php echo Yii::app()->baseUrl.'/';?>";
	var alertstimout = 10000;
	var timetoexpire = '<?php echo $timeRemaining;?>';
	var alerts = [{'name':'alert-msg-box','remainingtime':5,'appeared':false,'closetime':alertstimout},
				{'name':'warning-msg-box','remainingtime':7,'appeared':false,'closetime':alertstimout},
				{'name':'red-light-box','remainingtime':5,'appeared':false,'closetime':alertstimout},
				{'name':'warning-light-box','remainingtime':7,'appeared':false,'closetime':alertstimout}];
	// console.log(initial_question_list_data,current_statistics);

	$(document).ready(function(){
		// var liftoffTime = '+32m'; // +2h  //+600; // new Date();
		if(timetoexpire=='+0h +0m +0s'){
			finishExam(0); 
		}else{
			$("#spanCountdown").countdown({
				until: timetoexpire, 
				compact: true, 
				format: 'HMS',
				onExpiry: function(){
					finishExam(0);
				},
				onTick: function(preiods){
					if(preiods[4]==0 && preiods[5]==alerts[2].remainingtime && !alerts[2].appeared){
						// $('#warning_alert').css('display','none');
						// $('#red_alert').css('display','inline-block');
						showHideAlerts(true,1,2);
						showHideAlerts(true,2,0);
					}
					if(preiods[4]==0 && preiods[5]==alerts[3].remainingtime  && !alerts[3].appeared){
						// $('#warning_alert').css('display','inline-block');
						showHideAlerts(true,1,3);
						showHideAlerts(true,2,1);
					}
				}
			});
		}
		initQuestionBar();
		updateStatus(status);
	});
	function showHideAlerts(showhide,alerttype,type){
		if(showhide){
			if(alerttype==1){ // Lights
				if(type==3){
					$('#warning_alert').css('display','inline-block');
					alerts[3].appeared = true;
				}else if(type==2){
					$('#warning_alert').css('display','none');
					$('#red_alert').css('display','inline-block');
					alerts[2].appeared = true;
				}
			}else if(alerttype==2){ // Messages
				if(type==1){
					$('#warning-msg-box').show('slow');
					alerts[1].appeared = true;
					setTimeout( function() { showHideAlerts(false,2,1); },alerts[1].closetime);
				}else if(type==0){
					$('#alert-msg-box').show('slow');
					alerts[0].appeared = true;
					setTimeout( function() { showHideAlerts(false,2,0); },alerts[0].closetime);
				}
			}
		}else{
			if(alerttype==2){ // Messages
				if(type==1){
					$('#warning-msg-box').hide('slow');
				}else if(type==0){
					$('#alert-msg-box').hide('slow');
				}
			}
		}
	}
	function initQuestionBar(){
		var html = '';
		for (var i = 0; i < initial_question_list_data.length; i++) {
			var div = $('<div>').attr('id','questionbutton_'+initial_question_list_data[i].key_id+'_'+initial_question_list_data[i].question_id).attr('onclick','moveToQuestion(2,'+initial_question_list_data[i].key_id+')').addClass('questionbutton_'+initial_question_list_data[i].answer_status).html(initial_question_list_data[i].key_id);
			$("#question_button_container").append(div);
			// html+='<div onclick="moveToQuestion(2,'+initial_question_list_data[i].key_id+')" class="questionbutton_'+initial_question_list_data[i].answer_status+'" id="questionbutton_'+initial_question_list_data[i].key_id+'_'+initial_question_list_data[i].question_id+'">'+initial_question_list_data[i].key_id+'</div>';
		};
		// $("#question_button_container").html(html);
	}
	function moveToQuestion(action,questionNumber){
		previous_question = current_question;
		if(action==0){
			if(current_question==total_question){
				return false;
			}
			current_question++;
			showHideQuestion(current_question);
		}else if(action==1){
			if(1==current_question){
				return false;
			}
			current_question--;
			showHideQuestion(current_question);
		}else if(action==2){
			if(questionNumber>=1 && questionNumber<=total_question){
				current_question = questionNumber;
			}
			if(current_question!=previous_question){
				showHideQuestion(current_question);
			}
		}
	}
	function showHideQuestion(questionNumber){
		$(".question_div").removeClass('active_question');
		$("#question_"+questionNumber).addClass('active_question');
		updateStatus(1);
	}
	function updateStatus(status){
		var questiondetail = getQuestionDetail();
		if(!questiondetail){ return false; }
		// TO UPDATE THE STATUS
		$.ajax({
			type:'POST',
			url:baseurl+'exam/savestatus',
			data:{status:status,user_exam_id:questiondetail.user_exam_id,questionid:questiondetail.question_id},
			dataType:'JSON',
			success:function(data){
				if(data){
					if(data.error==0){
						$("#question_"+current_question).attr('user-que-ans',questiondetail.key_id+'_'+questiondetail.user_exam_id+'_'+questiondetail.question_id+'_'+status);
						var cls = $("#questionbutton_"+questiondetail.key_id+"_"+questiondetail.question_id).attr('class');
						cls = cls.split('_')[1];
						if(cls<1){
							refreshQuestionStatistics(questiondetail.key_id,1);
							$("#questionbutton_"+questiondetail.key_id+"_"+questiondetail.question_id).removeClass('questionbutton_0').addClass('questionbutton_1');
						}
					}						
				}
			}
		});
	}
	function refreshQuestionStatistics(key_id,status){
		var statistics = {'total_question':initial_question_list_data.length,'total_attempted':0,'total_not_attempted':0};
		for (var i = initial_question_list_data.length - 1; i >= 0; i--) {
			if(initial_question_list_data[i].key_id == key_id){
				initial_question_list_data[i].answer_status = status;
			}
			if(initial_question_list_data[i].answer_status==3){
				statistics.total_attempted = statistics.total_attempted+1;
			}else{
				statistics.total_not_attempted = statistics.total_not_attempted+1;
			}
		};
		$("#total_submitted_que").html(statistics.total_attempted);
		$("#total_pending_que").html(statistics.total_not_attempted);
	}
	function showError(error){
		alert(error)
	}
	function saveQuestion(status){
		if(status!=2 && status!=3){ showError('There is some temparing detected with code please refresh page and save again.'); return false;}
		var questiondetail = getQuestionDetail();
		if(!questiondetail){ return false;}
		var answer_option = $('input[name=option_'+questiondetail.question_id+']:checked').val();
		// console.log(answer_option,questiondetail);
		if(answer_option!=undefined || answer_option>0){
			if(status==2){showHideProcessing(1,'Saving...');}else if(status==3){showHideProcessing(1,'Submitting..');}
			$.ajax({
				type:'POST',
				url:baseurl+'exam/saveanswer',
				data:{status:status,chooseoption:answer_option,user_exam_id:questiondetail.user_exam_id,questionid:questiondetail.question_id},
				dataType:'JSON',
				success:function(data){
					if(data){
						if(data.error==1){
							alert(data.msg);
						}else{
							$("#question_"+current_question).attr('user-que-ans',questiondetail.key_id+'_'+questiondetail.user_exam_id+'_'+questiondetail.question_id+'_'+status);

							$("#questionbutton_"+questiondetail.key_id+"_"+questiondetail.question_id).removeClass('questionbutton_0').removeClass('questionbutton_1').removeClass('questionbutton_2').removeClass('questionbutton_3').addClass('questionbutton_'+status);
							refreshQuestionStatistics(questiondetail.key_id,status);
						}						
					}
					showHideProcessing(0);
				}
			});
		}else{
			showError('Please select right option.')
		}
		// console.log(questiondetail,answer_option);
	}
	function getQuestionDetail(){
		var question_detail = false;
		var val = $("#question_"+current_question).attr('user-que-ans');
		if(val!=''){
			var values = val.split('_');
			question_detail = {};
			question_detail.key_id = current_question;
			question_detail.user_exam_id = values[1];
			question_detail.question_id = values[2];
			question_detail.status = values[3];
		}
		return question_detail;
	}
	function finishExam(confirmation){
		if(confirmation){
			if(confirm('Do you really want to submit this exam completely?')){
				redirectToResult();
			}
		}else{
			redirectToResult();
		}
	}
	function redirectToResult(){
		window.location = baseurl+'exam/finish';
	}
	function showHideProcessing(flag,msg){
		if(msg!=''){
			$("#processing_bar_msg").html(msg);
		}else{
			$("#processing_bar_msg").html('Processing...');
		}
		if(flag){
			$("#processing_bar").css('visibility','visible');
		}else{
			$("#processing_bar").css('visibility','hidden');
		}
	}
</script>