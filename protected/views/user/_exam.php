<div class="exam-cnt-inner">
	<div><h3><?php echo $data->qt_name; ?></h3></div>
	<div>
		<?php
		$ansSubmit = 0;
		if(!empty($answers[$data->qt_id]['option'])){
			$ansSubmit = 1;			
		}
		if(!empty($data->qoptQat)){
			foreach ($data->qoptQat as $qtoKey => $qtoArr) {
				?>
				<div>
					<div>
						<input <?php echo (@$answers[$data->qt_id]['option']==$qtoArr->qto_id) ? 'checked' : ''; ?> type="radio" name="qtoname" value="<?php echo $qtoArr->qto_id; ?>" qid=<?php echo $data->qt_id; ?>>&nbsp;<b><?php echo $qtoArr->qto_name; ?></b>
					</div>
					<?php
					if($data->qt_type==2){
						?>
						<div>
							<img src="<?php echo Yii::app()->baseUrl; ?>/storage/qoptions/<?php echo $qtoArr->qto_image; ?>" width="100">
						</div>
						<?php
					}
					?>
				</div>
				<div>&nbsp;</div>
				<?php
			}
		}		
		?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exam-cnt-inner').on('click','input[type="radio"]',function(){
			$('#content .row-fluid').html('');
			var chooseoption = $(this).val();
			var questionid = $(this).attr('qid');
			var url = '<?php echo Yii::app()->baseUrl; ?>/user/saveanswer';
			var totalscore = parseInt($('.totalscore span#score').html());
			$.ajax({
				type:'POST',
				url:url,
				data:{chooseoption:chooseoption,questionid:questionid},
				dataType:'JSON',
				success:function(data){
					if(data){
						if(data.error==1){
							alert(data.msg);
						}else{
							var qattended = parseInt($('#qattended').html());
							var qTotal = (qattended+1);
							$('#qattended').html(qTotal);
							if(data.data.rightanswer==chooseoption){
								var qScore = parseInt(data.data.qScore);
								totalscore = totalscore+qScore;
							}
							$('.totalscore span#score').html(totalscore);
							var html = '';
							html += '<div class="alert alert-success">';
						    html += '<button class="close" data-dismiss="alert" type="button">&times;</button>';                              
						    html += data.msg;
						    html += '</div>';
						    $('#content .row-fluid').html(html);						    
						}
						$.fn.yiiListView.update("questionView");
					}
				}
			});
		});
	});
</script>