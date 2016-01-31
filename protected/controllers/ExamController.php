<?php

class ExamController extends Controller
{
	public $questions_json = array();
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax'])){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionUpcoming(){
		$examModel = new Exams;
		// $examDataProvider = $examModel->getexams();
		$examDataProvider = $examModel->getUpcomingExams();
    	$this->render('upcoming',array('examDataProvider' => $examDataProvider));
    }

    public function actionAttempted(){
    	$model=new UserExams;
    	if(!empty($_GET)){
    		$model->ex_title = $_GET['UserExams']['ex_title'];
    		$model->ex_details = $_GET['UserExams']['ex_details'];
    		$model->ex_start_date_time = $_GET['UserExams']['ex_start_date_time'];
    		$model->ex_end_date_time = $_GET['UserExams']['ex_end_date_time'];
    		$model->cat_name = $_GET['UserExams']['cat_name'];
    	}
		$dataProvider = $model->search();
		$params = array('dataProvider' => $dataProvider, 'model' => $model);
    	$this->render('attempted',$params);
    }

    public function actionStart($id){
    	$ur_exam_id = $id;
    	if(empty($ur_exam_id)){
    		$this->redirect(array('site/error'));
    	}
    	if(isset(Yii::app()->session['exam_started']) && Yii::app()->session['exam_started']==1){
    		// directly redirect on exam page
    		$this->redirect(array('exam/paper'));
    	}
		$data['ex_title'] = 'demo';
		$params = array('examdata' => $data,'ur_exam_id'=> $ur_exam_id,'wait_for_start'=>Yii::app()->session['wait_for_start']);
    	$this->render('start',$params);
    }

	public function actionPaper(){
		// echo '<pre>';
		// $this->layout = 'paper';
		$user_id = Yii::app()->user->id;
		if(Yii::app()->request->isPostRequest){
			// echo 'not direct'; exit;
			$exam_id = Yii::app()->request->getPost('ur_exam_id');
			if(empty($exam_id) || empty($user_id)){
				$this->redirect(array('exam/start/'.$exam_id));	
				// throw new CHttpException(404,'The requested page does not exist.');
			}

			$exam = Exams::model()->findByPk($exam_id);
			if(empty($exam) || $exam->ex_status!=1){
				Yii::app()->session['wait_for_start'] = 1;
				$this->redirect(array('exam/start/'.$exam_id));	
			}
			$examEntry = UserExams::model()->getUserExamEntry($user_id,$exam_id);

			if(empty($examEntry)){
				// do entry
				$examEntry = UserExams::model()->putUserExamEntry($user_id,$exam_id); // new UserExams();
				// echo 'ue_id: '.$examEntry->ue_id; exit;
				if(isset($examEntry->ue_id) && $examEntry->ue_id>0){
					// Create all the questions for this user for this exam.
					$uaModel = new UserAnswers;
					$answers = $uaModel->generateUserAnswersQuestion($user_id,$exam_id,$examEntry->ue_id);
					if(count($answers)>0){
						Yii::app()->session['exam_started'] = 1;
						Yii::app()->session['user_exam_id'] = $examEntry->ue_id;	
					}else{
						// Error handle here redirect on exam start page or exam list page
					}
				}else{
					// Error handle here redirect on exam start page or exam list page
				}
			}else{
				// echo 'ue_id else : '.$examEntry->ue_id; exit;
				if(isset($examEntry->ue_id) && $examEntry->ue_id>0){
					// check if user answer table entries exists or not
					$uaModel = new UserAnswers;
					$answers = $uaModel->getUserAnswersQuestion($user_id,$examEntry->ue_id);
					if(count($answers)>0){
						Yii::app()->session['exam_started'] = 1;
						Yii::app()->session['user_exam_id'] = $examEntry->ue_id;	
					}else{
						// Create all the questions for this user for this exam.	
						$answers = $uaModel->generateUserAnswersQuestion($user_id,$exam_id,$examEntry->ue_id);
						if(count($answers)>0){
							Yii::app()->session['exam_started'] = 1;
							Yii::app()->session['user_exam_id'] = $examEntry->ue_id;	
						}else{
							// Error handle here redirect on exam start page or exam list page
						}
					}
				}else{
					// Error handle here redirect on exam start page or exam list page
				}
			}
			$this->redirect(array('exam/paper'));
		}else{
			// echo 'direct'; exit;
			if(Yii::app()->session['exam_started'] && Yii::app()->session['user_exam_id']){
				$examdetail = UserExams::model()->getExamDetail($user_id,Yii::app()->session['user_exam_id']);
				$uaModel = new UserAnswers;
				$questions = $uaModel->getUserQuestions($user_id,Yii::app()->session['user_exam_id']);
				$statistics = $uaModel->getUserQuestionsStatistics($user_id,Yii::app()->session['user_exam_id']);
				// echo '<pre>';print_r($examdetail); exit;
				// foreach ($questions as $key => $value) {
					# code...
					// print_r($value);
				// }
				if(!empty(Yii::app()->session['startTime'])){
					$startTime = Yii::app()->session['startTime'];
				}else{
					Yii::app()->session['startTime'] = date('Y-m-d H:i:s');
					$startTime = Yii::app()->session['startTime'];
				}

				$date1= "2017-07-03 11:00:00";
				// $new_date= date("Y-m-d H:i:s", strtotime($date1 . " +3 hours"));

				$calculatedtime = $this->addDurationTime(Yii::app()->session['startTime'],$examdetail['ex_duration']);
				// $timeRemain = $this->getRemainingTime(date('Y-m-d H:i:s'),$calculatedtime);
				// $timeRemain = $this->getRemainingTime($calculatedtime,date('Y-m-d H:i:s'));
				// echo '<pre>'.Yii::app()->session['startTime'].'<br/>';
				// echo date('Y-m-d H:i:s').'<br/>';
				// echo $calculatedtime;
				// print_r(array($calculatedtime,Yii::app()->session['startTime'],$examdetail['ex_duration'])); exit;
				// $timeRemain = $this->getRemainingTime(date('Y-m-d H:i:s'),'2016-01-24 22:57:46');

				// $calculatedtime = '2016-01-24 23:07:50';
				$current_time = date('Y-m-d H:i:s');
				if(strtotime($current_time) < strtotime($calculatedtime)){
					$timeRemain = $this->getRemainingTime(date('Y-m-d H:i:s'),$calculatedtime);
					$timeRemaining = '+'.$timeRemain['hours'].'h +'.$timeRemain['minutes'].'m +'.$timeRemain['seconds'].'s';
				}else{
					$timeRemaining = '+0h +0m +0s';
				}
				// $timeRemain = $this->getRemainingTime(Yii::app()->session['startTime'],$date1);
				// $timeRemaining = '+'.$timeRemain['hours'].'h +'.$timeRemain['minutes'].'m +'.$timeRemain['seconds'].'s';
				// echo $timeRemaining; exit;
				$totalQuestions = count($questions)/4;
				$totalScore = array('total_attempted'=>0,'total_not_attempted'=>0);
				$questionsCount = 0;
				$answersCount = 0;
				// print_r($questions); exit;
				$this->render('paper',array('timeRemaining'=>$timeRemaining,'statistics'=>$statistics,
					'exams'=>$examdetail,'questions_json' => $this->questions_json,'dataProvider' => $questions,'totalQuestions'=>$totalQuestions));
				// echo ' true conditon '; exit;
			}else{
				$this->redirect(array('exam/start'));
			}
		}
	}

	protected function addDurationTime($date,$addextratime){
		$duration = explode(":", $addextratime);
		$date1= date("Y-m-d H:i:s", strtotime($date . " +".$duration[0]." hours"));
		$new_date= date("Y-m-d H:i:s", strtotime($date1 . " +".$duration[1]." minutes"));
		return $new_date;
	}

	protected function getRemainingTime($startdate,$enddate){
		// $startdate="2016-01-25 01:05:00"; 
		// $enddate="2016-01-25 01:10:00"; 
		$diff=strtotime($enddate)-strtotime($startdate); 
		// immediately convert to days 
		$temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day 
		// days 
		$days=floor($temp); 
		// echo "days: $days<br/>\n"; 
		$temp=24*($temp-$days); 
		// hours 
		$hours=floor($temp); 
		// echo "hours: $hours<br/>\n"; 
		$temp=60*($temp-$hours); 
		// minutes 
		$minutes=floor($temp); 
		// echo "minutes: $minutes<br/>\n"; 
		$temp=60*($temp-$minutes); 
		// seconds 
		$seconds=floor($temp); 
		// echo "seconds: $seconds<br/>\n<br/>\n";
		// return '+'.$hours.'h +'.$minutes.'m +'.$seconds.'s';
		return array('hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds);
	}

	public function actionSaveanswer(){
		$user_id = Yii::app()->user->id;
		$return['msg'] = 'Please select anyone answer.';
		$return['error'] = 1;
		$return['data'] = '';
		$this->layout = false;
		if(Yii::app()->request->isAjaxRequest){
			// status // 2 , 3
			if(!empty($_POST['chooseoption']) && !empty($_POST['questionid']) && !empty($_POST['user_exam_id']) ){
				$chooseOption = $_POST['chooseoption'];
				$questionId = $_POST['questionid'];
				$user_exam_id = $_POST['user_exam_id'];
				$status = $_POST['status'];
				// $qModel = Questions::model()->findByPk($questionId);
				
				$criteria=new CDbCriteria;
				$criteria->condition = "qto_question_id=:qto_question_id AND qto_right_ans=:qto_right_ans";
				$criteria->params = array(':qto_question_id' => $questionId,':qto_right_ans' => 1);
				$opModel = QuestionsOptions::model()->find($criteria);

				$_answer = 0;
				$rightanswer = '';
				if($opModel){
					// echo $opModel->qto_id; exit;
					if($opModel->qto_id==$chooseOption){
						$_answer = 1;
					}
					$rightanswer = $opModel->qto_id;
				}
				// if($qModel){				
					$ansCriteria = new CDbCriteria;
					// ua_exam_id=:ua_exam_id
					// $ansCriteria->condition = "ua_user_id=:ua_user_id AND ua_question_id=:ua_question_id AND ua_user_exam_id:ua_user_exam_id";
					$ansCriteria->condition = "ua_id=:ua_id";
					// ':ua_exam_id' => $qModel->qt_exam_id,
					// $ansCriteria->params = array(':ua_user_id' => $user_id,':ua_question_id' => $questionId, ':ua_user_exam_id'=>$user_exam_id);
					$ansCriteria->params = array(':ua_id'=>$user_exam_id);
					$ansModel = UserAnswers::model()->find($ansCriteria);

					// $model = new UserAnswers;
					// $model->ua_user_id = $user_id;
					// $model->ua_question_id = $questionId;
					// $model->ua_option_id = $chooseOption;
					// $model->ua_exam_id = $qModel->qt_exam_id;
					// $model->ua_user_exam_id = $user_exam_id;
					// $model->ua_answer_status = $status;
					// $model->ua_answer = $_answer;
					
					if(!empty($ansModel->ua_id)){
						// $model->ua_id = $ansModel->ua_id;
						// $model->isNewRecord = false;
						$ansModel->ua_answer_status = $status;
						$ansModel->ua_answer = $_answer;
						$ansModel->ua_option_id = $chooseOption;
					}

					if($ansModel->save()){
						$return['msg'] = 'Answer saved successfully.';
						$return['error'] = 0;
						// $return['data'] = array('isWrongAnswer' => $_answer, 'rightanswer' => $rightanswer,'qScore' => $qModel->qt_marks);
						$return['data'] = array('isWrongAnswer' => 1, 'rightanswer' => 1,'qScore' => 1);
					}else{
						$return['msg'] = 'Answer not saved successfully please refresh and try again.';
						$return['error'] = 1;
						$return['data'] = array('isWrongAnswer' => 1, 'rightanswer' => 1,'qScore' => 1);
					}									
				// }
			}			
		}
		echo CJSON::encode($return);
	}

	public function actionSavestatus(){
		$user_id = Yii::app()->user->id;
		$return['msg'] = 'Please select anyone answer.';
		$return['error'] = 1;
		$return['data'] = '';
		$this->layout = false;
		if(Yii::app()->request->isAjaxRequest){
			// status // 2 , 3
			if(!empty($_POST['questionid']) && !empty($_POST['questionid']) && !empty($_POST['user_exam_id']) ){
				$questionId = $_POST['questionid'];
				$user_exam_id = $_POST['user_exam_id'];
				$status = $_POST['status'];

				$ansCriteria = new CDbCriteria;
				$ansCriteria->condition = "ua_id=:ua_id";
				$ansCriteria->params = array(':ua_id'=>$user_exam_id);
				$ansModel = UserAnswers::model()->find($ansCriteria);
				
				if(!empty($ansModel->ua_id)){
					if($ansModel->ua_answer_status==0 || $ansModel->ua_answer_status==1){
						$ansModel->ua_answer_status = $status;	
						if($ansModel->save()){
							$return['msg'] = 'Status updated successfully.';
							$return['error'] = 0;
							// $return['data'] = array('isWrongAnswer' => $_answer, 'rightanswer' => $rightanswer,'qScore' => $qModel->qt_marks);
							$return['data'] = array('isWrongAnswer' => 1, 'rightanswer' => 1,'qScore' => 1);
						}else{
							$return['msg'] = 'Status not updated successfully please refresh and try again.';
							$return['error'] = 1;
							$return['data'] = array('isWrongAnswer' => 1, 'rightanswer' => 1,'qScore' => 1);
						}
					}else{
						$return['msg'] = 'No need to update this status.';
						$return['error'] = 0;
						$return['data'] = array('isWrongAnswer' => 1, 'rightanswer' => 1,'qScore' => 1);
					}
				}
			}			
			echo CJSON::encode($return);
		}else{
			$this->redirect(array('/'));
		}
	}

	public function actionFinish(){
		$user_id = Yii::app()->user->id;
		if($user_id>0 && Yii::app()->session['exam_started'] && Yii::app()->session['user_exam_id']>0){
			$user_exam_id = Yii::app()->session['user_exam_id'];
			$criteria = new CDbCriteria;
			$criteria->condition = "ue_id=:ue_id";
			$criteria->params = array(':ue_id'=>$user_exam_id);
			$model = UserExams::model()->find($criteria);

			$model->ue_exam_end = date('Y-m-d H:i:s');
			$timediff = $this->getRemainingTime($model->ue_exam_end,Yii::app()->session['startTime']);
			$model->ue_total_timespent = $timediff['hours'].':'.$timediff['minutes'].':'.$timediff['seconds'];
			$model->ue_is_finished = 1;

			$statistics = UserAnswers::model()->getUserQuestionsStatistics($user_id,$user_exam_id);
			$model->ue_total_question = $statistics['total_question'];
			$model->ue_total_attempted = $statistics['total_attempted'];
			$model->ue_total_reviewed = $statistics['total_not_attempted'];
			$model->ue_total_submitted = $statistics['total_submitted'];
			$model->ue_total_marks = $statistics['total_correct'];
			$model->save();

			/*if($model->save()){
				echo 'saved'; exit;
			}else{
				echo 'not saved'; exit;
			}*/
			// Yii::app()->session['exam_started'] = false;
			// Yii::app()->session['user_exam_id'] = false;
			unset(Yii::app()->session['exam_started']);
			unset(Yii::app()->session['user_exam_id']);
			unset(Yii::app()->session['startTime']);
			$this->redirect(array('exam/detail/'.$user_exam_id));
		}else{
			$this->redirect(array('exam/upcoming'));
		}
	}

	public function actionDetail($id){
		$user_id = Yii::app()->user->id;

		if(empty($id))
			throw new CHttpException(404,'The requested page does not exist.');

		/*$criteria1=new CDbCriteria;
		$criteria1->condition = "qt_exam_id=:qt_exam_id";
		$criteria1->params = array(':qt_exam_id' => $id);
		$questions = Questions::model()->findAll($criteria1);

		$criteria2=new CDbCriteria;
		$criteria2->condition = "ua_user_id=:ua_user_id and ua_user_exam_id=:ua_user_exam_id";
		$criteria2->params = array(':ua_user_id' => $user_id,'ua_user_exam_id' => $id);
		$answers = UserAnswers::model()->findAll($criteria2);

		$examDetail = Exams::model()->findByPk($id);
		$totalScore = UserAnswers::model()->getCountRightAns($id);*/

		$statistics = UserExams::model()->getStatistics($id);
		$this->render('detail',array('statistics' => $statistics));
	}
}
