<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSignup()
	{
		$this->containercls = 'nobackground';
		//echo CHtml::image(Yii::app()->acaptcha->create()); 
		if(Yii::app()->user->isGuest){
			$model=new User;
			$model->scenario = 'insert';
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
	
			if(isset($_POST['User'])){
				$salt = md5(uniqid(rand(), true));
				$_POST['User']['u_verkey'] = $salt;
				$model->attributes=$_POST['User'];
				$model->u_status = 1;	
				if($model->save()){
					$username = $model->u_first_name.' '.$model->u_last_name;
					$request = 	array('{verification_link}'=>$salt,'{username}'=>$username);
					if($this->sendEmail(1,$model->u_email,$request)){
						Yii::app()->user->setFlash('success','A verification link has been sent to your registered email address, Please verify to access your '.Yii::app()->params['title'].' account.');
					}else{
						Yii::app()->user->setFlash('error','Error in sending verification mail. Please contact site administrator.');
					}
					$this->redirect(array('/'));
				}
			}
			
			$this->render('signup',array(
				'model'=>$model,				
			));
		}else{
			$this->redirect(array('/dashboard'));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionProfile()
	{
		$this->tabs = true;
		$user_id = Yii::app()->user->id;
		$model=$this->loadModel($user_id);
		$model->scenario = 'useredit';		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if(isset($_POST['user_image']) && !empty($_POST['user_image'])){
				$oldimage = ($model->u_image!='')?$model->u_image:NULL;
				$model->u_image = $this->UploadImage($_POST['user_image'],'user',$oldimage);					
			}
			unset($model->u_last_login_date);
			unset($model->u_created);
			if($model->save())
			{
				Yii::app()->user->setFlash('success','Profile updated successfully.');
				$this->refresh();
			}else{
				Yii::app()->user->setFlash('error','Please verify all the fields.');
				
			}
		}
		
		$criteria=new CDbCriteria;
		$criteria->order = 'cnt_name ASC';
		$userAddressModel = new UserAddress;

		$countriesData = Countries::model()->findAll($criteria);
		$countries = CHtml::listData($countriesData,'cnt_id','cnt_name');
		$states1 = array();
		$states2 = array();

		$criteria1=new CDbCriteria;
		$criteria1->condition = "uad_user_id=:uad_user_id";
		$criteria1->params = array(':uad_user_id' => $user_id);
		$userAddress = UserAddress::model()->findAll();
		$address = array();
		if(!empty($userAddress)){
			foreach ($userAddress as $key => $arr) {
				$uad_type = $arr->uad_type;
				$address[$uad_type]['uad_id'] = $arr->uad_id;
				$address[$uad_type]['uad_add1'] = $arr->uad_add1;
				$address[$uad_type]['uad_add2'] = $arr->uad_add2;
				$address[$uad_type]['uad_country_id'] = $arr->uad_country_id;
				$address[$uad_type]['uad_state_id'] = $arr->uad_state_id;
				$address[$uad_type]['uad_city'] = $arr->uad_city;
				$address[$uad_type]['uad_zipcode'] = $arr->uad_zipcode;
				$address[$uad_type]['uad_mobile'] = $arr->uad_mobile;
			}
		}

		$criteria=new CDbCriteria;
		$criteria->order = "st_name ASC";
		$criteria->condition = "st_cnt_id=:st_cnt_id";
		if(!empty($address[1]['uad_country_id'])){
			$criteria->params = array(':st_cnt_id' => $address[1]['uad_country_id']);					
			$statesData = States::model()->findAll($criteria);
			$states1 = CHtml::listData($statesData,'st_id','st_name');
		}
		if(!empty($address[2]['uad_country_id'])){
			$criteria->params = array(':st_cnt_id' => $address[2]['uad_country_id']);					
			$statesData = States::model()->findAll($criteria);
			$states2 = CHtml::listData($statesData,'st_id','st_name');
		}

		$this->render('profile',array(
			'model'=>$model,
			'userAddressModel' => $userAddressModel,
			'countries' => $countries,
			'states1' => $states1,
			'states2' => $states2,
			'address' => $address
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionVerify($key){    	
    	$check = User::model()->find('u_verkey = :u_verkey',array(':u_verkey'=>$key));    	
    	if($check){    		
    		if($check->updateByPk($check->u_id,array('u_mail_verify'=>'1','u_verkey'=>''))){
    			Yii::app()->user->setFlash('popupmsg','Your account has been successfully verified, Please login to access your '.Yii::app()->params['title'].' account.');
    			$this->redirect(array('/'));
    		}
    	}else{
			Yii::app()->user->setFlash('popupmsg','Invalid or expired key code.');
			$this->redirect(array('/'));
		}
    }

    public function actionCaptcha($v=0){

		Yii::app()->acaptcha->create(array(),$v);
		Yii::app()->end();    	
    }

    public function actionResetpassword($key=NULL){    	    	
    	
		$check = User::model()->find('u_scrkey = :u_scrkey',array(':u_scrkey'=>$key));    			
		$check->scenario = 'resetpass';
		if($check){			
			if(isset($_POST['User'])){	
				
				$check->attributes = $_POST['User'];				
				$check->u_scrkey = "";	
				if($check->save()){
					Yii::app()->user->setFlash('popupmsg','Your password has been successfully reset.');
					$this->redirect(array("/"));
				}
			}
		}else{
			Yii::app()->user->setFlash('popupmsg','Invalid or expired key code.');			
			$this->redirect(array("/"));			
		}		
		$check->u_password = '';
		$this->render('resetpassword',array('model'=>$check));			
    }
    
    public function actionDashboard(){
    	$this->tabs = true;
    	$model=new Exams;
		$dataProvider = $model->getexams();
		$params = array('dataProvider' => $dataProvider);
    	$this->render('dashboard',$params);
    }
    
    public function actionChangepassword(){
		$model=User::model()->findByPk(Yii::app()->user->id);
		$model->scenario = 'changepassword';
		if(isset($_POST['User'])){
			$model->attributes=$_POST['User'];			
			if($model->validate() && $model->save()){				
				Yii::app()->user->setFlash('success','Password updated successfully.');
				$this->redirect(array('dashboard'));
			}else{				
				$t = $model->getErrors();
								
				if(!empty($t)){
					Yii::app()->user->setFlash('error','Please validate all the fields.');
				}
				else
					Yii::app()->user->setFlash('error','Error in save, Please try again.');
			} 
		}
		$this->render('changepassword',array('model'=>$model));
	}
    /*
     * FOR UPLOADING IMAGES
     */
    
    public function actionReverify($email=NULL){
    	if($email){
    		$user = User::model()->find('u_email = :u_email AND u_mail_verify = 0',array(':u_email'=>$email));
    		if($user){
    			$salt = $user->u_verkey;
    			$username = $user->u_first_name.' '.$user->u_last_name;
				$request = 	array('{verification_link}'=>$salt,'{username}'=>$username);
				if($this->sendEmail(1,$user->u_email,$request)){
					Yii::app()->user->setFlash('popupmsg','A verification link has been sent to your email address, Please verify to access your '.Yii::app()->params['title'].' account.');
				}	
    		}else{
    			Yii::app()->user->setFlash('popupmsg','Invalid Request.');				    			
    		}
    	}else{
			Yii::app()->user->setFlash('popupmsg','Invalid Request.');
			
    	}    	
    	$this->redirect(array("/"));
    }

    public function actionForgotpassword(){
		$this->layout = '/layouts/login';
		$model = new ForgotPassword();		
		if(isset($_POST['ForgotPassword'])){
			$model->attributes = $_POST['ForgotPassword'];
			if($model->validate()){
				$user = User::model()->find('LOWER(u_email)=:email',array(':email'=>strtolower($model->username)));		        	
	        	$salt = md5(uniqid(rand(), true));		        	
	        	$username = $user->u_username;
				$request = 	array('{reset_link}'=>$salt,'{username}'=>$username);
				if($this->sendEmail(2,$user->u_email,$request)){						
					if($user->updateByPk($user->u_id,array('u_scrkey'=>$salt))){
						Yii::app()->user->setFlash('success','A link has been sent to your email address to reset the password.');
						$this->redirect(array('site/login'));
					}else{
						Yii::app()->user->setFlash('success','Error in setting the reset key.');
					}
				}
			}
		}
		$this->render('forgotpassword',array('model'=>$model));		
	}

	public function actionSaveaddress(){
		$user_id = Yii::app()->user->id;
		if(!empty($_POST['UserAddress']['uad_type'])){
			foreach ($_POST['UserAddress']['uad_type'] as $key => $uad_type) {
				$model = new UserAddress;
				$model->uad_type = $uad_type;
				$model->uad_user_id = $user_id;
				$model->uad_add1 = $_POST['UserAddress']['uad_add1'][$uad_type];
				$model->uad_add2 = $_POST['UserAddress']['uad_add2'][$uad_type];
				$model->uad_country_id = $_POST['UserAddress']['uad_country_id'][$uad_type];
				$model->uad_state_id = $_POST['UserAddress']['uad_state_id'][$uad_type];
				$model->uad_city = $_POST['UserAddress']['uad_city'][$uad_type];
				$model->uad_zipcode = $_POST['UserAddress']['uad_zipcode'][$uad_type];
				$model->uad_mobile = $_POST['UserAddress']['uad_mobile'][$uad_type];
				if(!empty($_POST['UserAddress']['uad_id'][$uad_type])){
					$model->uad_id = $_POST['UserAddress']['uad_id'][$uad_type];
					$model->isNewRecord = false;
				}else{
					$model->isNewRecord = true;
				}				
				$model->save(false);
			}
		}
		Yii::app()->user->setFlash('success','Address updated successfully.');
		$this->redirect(array('user/profile'));
	}

	public function actionStates(){
		$states = array();
		if(!empty($_POST['cnt_id'])){
			$criteria=new CDbCriteria;
			$criteria->order = "st_name ASC";
			$criteria->condition = "st_cnt_id=:st_cnt_id";
			$criteria->params = array(':st_cnt_id' => $_POST['cnt_id']);
			$statesData = States::model()->findAll($criteria);
			$states = CHtml::listData($statesData,'st_id','st_name');
		}
		$this->renderPartial('_states',array('states' => $states));
	}

	public function actionExam($id){
		if(empty($id))
			throw new CHttpException(404,'The requested page does not exist.');
		$model=new Questions;
		$model->qt_exam_id = $id;
		$dataProvider = $model->getquestions();

		$uaModel = new UserAnswers;
		$answers = $uaModel->getAnswersQuestionWise($id);

		$totalScore = $uaModel->getTotalScore($id);

		$this->render('exam',array('dataProvider' => $dataProvider,'answers' => $answers,'totalScore' => $totalScore,'examId' => $id));
	}

	public function actionSaveanswer(){
		$user_id = Yii::app()->user->id;
		if(Yii::app()->request->isAjaxRequest){
			$return['msg'] = 'Please select anyone answer.';
			$return['error'] = 1;
			$return['data'] = '';
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
					$model = new UserAnswers;
					$model->ua_user_id = $user_id;
					$model->ua_question_id = $questionId;
					$model->ua_option_id = $chooseOption;
					if($model->save()){
						$return['msg'] = 'Answer saved successfully.';
						$return['error'] = 0;
						$return['data'] = array('isWrongAnswer' => $isWrongAnswer, 'rightanswer' => $rightanswer,'qScore' => $qModel->qt_marks);
					}										
				}
			}
			echo json_encode($return);
			exit;
		}
	}
}
