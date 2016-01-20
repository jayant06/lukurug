<?php

class ExamController extends Controller
{
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
		$examModel=new Exams;
		$examDataProvider = $examModel->getexams();
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

    public function actionStart(){
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

	public function actionPaper($id){
		$user_id = Yii::app()->user->id;
		if(empty($id))
			throw new CHttpException(404,'The requested page does not exist.');
		$model=new Questions;
		$model->qt_exam_id = $id;
		$dataProvider = $model->getquestions();

		$uaModel = new UserAnswers;
		$answers = $uaModel->getAnswersQuestionWise($id);

		$criteria1=new CDbCriteria;
		$criteria1->condition = "qt_exam_id=:qt_exam_id";
		$criteria1->select = array('qt_id');
		$criteria1->params = array(':qt_exam_id' => $id);
		$questionsCount = Questions::model()->findAll($criteria1);
		
		$criteria2=new CDbCriteria;
		$criteria2->condition = "ua_user_id=:ua_user_id and ua_exam_id=:ua_exam_id";
		$criteria2->select = array('ua_id');
		$criteria2->params = array(':ua_user_id' => $user_id,'ua_exam_id' => $id);
		$answersCount = UserAnswers::model()->findAll($criteria2);
		
		$totalScore = $uaModel->getTotalScore($id);
		$exams = Exams::model()->findByPk($id);

		if(empty(Yii::app()->session['startTime'][$id])){
			Yii::app()->session['startTime'] = array($id => date('Y-m-d').' '.date('H:i:s',strtotime(date('H:i:s'))+strtotime($exams->ex_duration)));
		}
		$startTime = Yii::app()->session['startTime'];
		$this->render('exam',array('startTime' => $startTime[$id],'exams' => $exams, 'dataProvider' => $dataProvider,'answers' => $answers,'totalScore' => $totalScore,'examId' => $id,'questionsCount' => $questionsCount,'answersCount' => $answersCount));
	}

	public function actionSaveanswer(){
		$user_id = Yii::app()->user->id;
		$return['msg'] = 'Please select anyone answer.';
		$return['error'] = 1;
		$return['data'] = '';
		if(Yii::app()->request->isAjaxRequest){
			if(!empty($_POST['chooseoption']) && !empty($_POST['questionid'])){
				$chooseOption = $_POST['chooseoption'];
				$questionId = $_POST['questionid'];
				$qModel = Questions::model()->findByPk($questionId);
				
				$criteria=new CDbCriteria;
				$criteria->condition = "qto_question_id=:qto_question_id AND qto_right_ans=:qto_right_ans";
				$criteria->params = array(':qto_question_id' => $questionId,':qto_right_ans' => 1);
				$opModel = QuestionsOptions::model()->find($criteria);

				$isWrongAnswer = 1;
				$rightanswer = '';
				if($opModel){
					if($opModel->qto_id==$chooseOption){
						$isWrongAnswer = 0;
					}
					$rightanswer = $opModel->qto_id;
				}
				if($qModel){				
					$ansCriteria = new CDbCriteria;
					$ansCriteria->condition = "ua_user_id=:ua_user_id AND ua_question_id=:ua_question_id and ua_exam_id=:ua_exam_id";
					$ansCriteria->params = array(':ua_user_id' => $user_id,':ua_question_id' => $questionId, ':ua_exam_id' => $qModel->qt_exam_id);
					$ansModel = UserAnswers::model()->find($ansCriteria);

					$model = new UserAnswers;
					$model->ua_user_id = $user_id;
					$model->ua_question_id = $questionId;
					$model->ua_option_id = $chooseOption;
					$model->ua_exam_id = $qModel->qt_exam_id;
					if(!empty($ansModel->ua_id)){
						$model->ua_id = $ansModel->ua_id;
						$model->isNewRecord = false;
					}
					if($model->save()){
						$return['msg'] = 'Answer saved successfully.';
						$return['error'] = 0;
						$return['data'] = array('isWrongAnswer' => $isWrongAnswer, 'rightanswer' => $rightanswer,'qScore' => $qModel->qt_marks);
					}										
				}
			}			
		}
		echo json_encode($return);
		exit;
	}

	public function actionFinish(){
		$user_id = Yii::app()->user->id;
		$return['msg'] = 'Invalid exam.';
		$return['error'] = 1;
		$return['data'] = '';
		if(Yii::app()->request->isAjaxRequest){
			if(!empty($_POST['examId'])){
				$examId = $_POST['examId'];
				if(!empty(Yii::app()->session['startTime'][$examId])){
					$startDate = Yii::app()->session['startTime'][$examId];
					$model = new UserExams;
					$model->ue_user_id = $user_id;
					$model->ue_exam_id = $examId;
					$model->ue_exam_start = date('Y-m-d H:i:s',strtotime($startDate));
					if($model->save()){
						$return['msg'] = 'Saved successfully.';
						$return['error'] = 0;
						$return['data'] = $model->ue_id;
					}
				}
			}
		}
		echo json_encode($return);
		exit;
	}

	public function actionDetail($id){
		$user_id = Yii::app()->user->id;

		if(empty($id))
			throw new CHttpException(404,'The requested page does not exist.');

		$criteria1=new CDbCriteria;
		$criteria1->condition = "qt_exam_id=:qt_exam_id";
		$criteria1->params = array(':qt_exam_id' => $id);
		$questions = Questions::model()->findAll($criteria1);

		$criteria2=new CDbCriteria;
		$criteria2->condition = "ua_user_id=:ua_user_id and ua_exam_id=:ua_exam_id";
		$criteria2->params = array(':ua_user_id' => $user_id,'ua_exam_id' => $id);
		$answers = UserAnswers::model()->findAll($criteria2);

		$examDetail = Exams::model()->findByPk($id);

		$totalScore = UserAnswers::model()->getCountRightAns($id);

		$this->render('detail',array('examDetail' => $examDetail, 'answers' => $answers, 'questions' => $questions, 'totalScore' => $totalScore));
	}
}
