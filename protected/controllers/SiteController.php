<?php
class SiteController extends Controller
{
	public $layout='main';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,												
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }else{
			$error = 'You are not authorise to access the page you requested';
			$this->render('illegal_access', array('error'=>$error));
		}
	}

	/**
	 * Displays the login page
	*/
	public function actionLogin(){
		
		// $this->layout = 'login';
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{ 
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				unset(Yii::app()->session['exam_started']);
				unset(Yii::app()->session['user_exam_id']);
				unset(Yii::app()->session['startTime']);
				$this->redirect(array('user/profile'));
			}
		}
		
		$this->render('login',array(
			'model'=>$model,
		));	
	}

	public function actionIndex(){
		$this->render('index');
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);	
		unset(Yii::app()->session['exam_started']);
		unset(Yii::app()->session['user_exam_id']);
		unset(Yii::app()->session['startTime']);
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionPages($id)
	{
		$this->containercls = 'nobackground';
		$model=Cmspage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else{
			$this->render('pages',array('model'=>$model));		
		}
	}

	public function actionAcaptcha(){
		Yii::app()->acaptcha->create();
		Yii::app()->end();
	}

	//FOR STORING TIMEZONE IN SESSION
	public function actionSettimezone(){
		if(Yii::app()->request->isAjaxRequest){
			$timezone = $_POST['timezone']*60;
			Yii::app()->session['TimeOffSet'] = $timezone;
			$this->ajaxResponse['error'] = '0';
			$this->ajaxResponse['message'] = 'Timezone saved.';
			echo CJSON::encode($this->ajaxResponse);
			Yii::app()->end();
		}		
	}
}
		