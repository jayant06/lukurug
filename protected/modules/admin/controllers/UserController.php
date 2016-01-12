<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
				'transparent'=>true,				
			),						
		);
	}
	
	/**
	 * @return array action filters
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','findstate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('signup','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */	
	public function actionEdit($id) { // function for Edit user detail
		
		$model=$this->loadModel($id);		
		$model->scenario = 'adminedit';		
		if(isset($_POST['User']))
		{
			unset($model->u_password);			
			if(!empty($_POST['User']['u_addmission_date'])){
				$aDate = explode('/',$_POST['User']['u_addmission_date']);
				$_POST['User']['u_addmission_date'] = $aDate[2]."-".$aDate[1]."-".$aDate[0];
			}
			$model->attributes=$_POST['User'];
			if(!empty($_POST['User']['u_image'])){
				$name = $_POST['User']['u_image'];
				$extension = pathinfo($name)['extension'];
				$file_name = uniqid().".".$extension;
				$dir_name 	= Yii::getPathOfAlias('webroot').'/storage/users/';
				$file_path 	= $dir_name.$file_name;
				$model->u_image = $file_name;
			}
			$model->u_mail_verify = 1;
			if($model->validate() && $model->save()){
				if(!empty($_POST['User']['u_image'])){
					if(copy($dir_name."temp/".$_POST['User']['u_image'], $file_path)){
						unlink($dir_name."temp/".$_POST['User']['u_image']);
					}
				}
				
				$userAddress = $_POST['UserAddress'];
				if(!empty($userAddress)){
					foreach ($userAddress['uad_type'] as $ukey => $uad_type) {
						$userAddressModel = new UserAddress;
						$userAddressModel->uad_type = $uad_type;
						$userAddressModel->uad_add1 = $userAddress['uad_add1'][$ukey];
						$userAddressModel->uad_add2 = $userAddress['uad_add2'][$ukey];
						$userAddressModel->uad_country_id = 105;
						$userAddressModel->uad_state_id = $userAddress['uad_state_id'][$ukey];
						$userAddressModel->uad_city = $userAddress['uad_city'][$ukey];
						$userAddressModel->uad_zipcode = $userAddress['uad_zipcode'][$ukey];
						$userAddressModel->uad_mobile = $userAddress['uad_mobile'][$ukey];
						$userAddressModel->uad_user_id = $model->u_id;
						if(!empty($userAddress['uad_id'][$ukey])){
							$userAddressModel->uad_id = $userAddress['uad_id'][$ukey];
							$userAddressModel->isNewRecord = false;
						}
						$userAddressModel->save();						
					}
				}

				if(!empty($_POST['user_cources'])){
					$criteria=new CDbCriteria;	
					$criteria->condition = 'cr_user_id=:cr_user_id';
					$criteria->params = array(':cr_user_id' => $model->u_id);
					UserCourses::model()->deleteAll($criteria);

					foreach ($_POST['user_cources'] as $ckey => $cid) {
						$usModel = new UserCourses;
						$usModel->cr_user_id = $model->u_id;
						$usModel->cr_category_id = $cid;
						$usModel->save();
					}
				}
				Yii::app()->user->setFlash('success','User updated successfully.');	
				$this->redirect(array('userlist'));
			}else{
				$t = $model->getErrors();				
				if(!empty($t)){					
					Yii::app()->user->setFlash('error','Please fill all the required fields.');	
				}
				else
					Yii::app()->user->setFlash('error','Error in save, Please try again.');	
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
		$criteria1->params = array(':uad_user_id' => $id);
		$userAddress = UserAddress::model()->findAll($criteria1);
		$address = array();
		if(!empty($userAddress)){
			foreach ($userAddress as $key => $arr) {
				$uad_type = $arr->uad_type;
				$address[$uad_type]['uad_id'] = $arr->uad_id;
				$address[$uad_type]['uad_add1'] = $arr->uad_add1;
				$address[$uad_type]['uad_add2'] = $arr->uad_add2;
				$address[$uad_type]['uad_country_id'] = 105;
				$address[$uad_type]['uad_state_id'] = $arr->uad_state_id;
				$address[$uad_type]['uad_city'] = $arr->uad_city;
				$address[$uad_type]['uad_zipcode'] = $arr->uad_zipcode;
				$address[$uad_type]['uad_mobile'] = $arr->uad_mobile;
			}
		}

		$criteria=new CDbCriteria;
		$criteria->order = "st_name ASC";
		$criteria->condition = "st_cnt_id=:st_cnt_id";
		$criteria->params = array(':st_cnt_id' => 105);					
		$statesData = States::model()->findAll($criteria);
		$states1 = CHtml::listData($statesData,'st_id','st_name');
		$states2 = CHtml::listData($statesData,'st_id','st_name');
		if(!empty($model->u_addmission_date)){
			$aDate = explode('-',$model->u_addmission_date);
			$model->u_addmission_date = $aDate[2]."-".$aDate[1]."-".$aDate[0];
		}

		$this->render('edit',array(
			'model'=>$model,
			'userAddressModel' => $userAddressModel,
			'countries' => $countries,
			'states1' => $states1,
			'states2' => $states2,
			'address' => $address
		));
	
	}
	public function actionAdd() { //function for create new user
		
		$model=new User;
		$model->scenario = 'admininsert';		
		if(isset($_POST['User']))
		{
			$salt = md5(uniqid(rand(), true));
			$_POST['User']['u_verkey'] = $salt;
			if(!empty($_POST['User']['u_addmission_date'])){
				$aDate = explode('/',$_POST['User']['u_addmission_date']);
				$_POST['User']['u_addmission_date'] = $aDate[2]."-".$aDate[1]."-".$aDate[0];
			}
			$model->attributes=$_POST['User'];	
			if(!empty($_POST['User']['u_image'])){
				$name = $_POST['User']['u_image'];
				$extension = pathinfo($name)['extension'];
				$file_name = uniqid().".".$extension;
				$dir_name 	= Yii::getPathOfAlias('webroot').'/storage/users/';
				$file_path 	= $dir_name.$file_name;
				$model->u_image = $file_name;
			}
			$model->u_status=1;
			$model->u_mail_verify = 1;
			if($model->validate() && $model->save()){
				if(!empty($_POST['User']['u_image'])){
					if(copy($dir_name."temp/".$_POST['User']['u_image'], $file_path)){
						unlink($dir_name."temp/".$_POST['User']['u_image']);
					}
				}
				$username = $model->u_username;
				$userAddress = $_POST['UserAddress'];
				if(!empty($userAddress)){
					foreach ($userAddress['uad_type'] as $ukey => $uad_type) {
						$userAddressModel = new UserAddress;
						$userAddressModel->uad_type = $uad_type;
						$userAddressModel->uad_add1 = $userAddress['uad_add1'][$ukey];
						$userAddressModel->uad_add2 = $userAddress['uad_add2'][$ukey];
						$userAddressModel->uad_country_id = 105;
						$userAddressModel->uad_state_id = $userAddress['uad_state_id'][$ukey];
						$userAddressModel->uad_city = $userAddress['uad_city'][$ukey];
						$userAddressModel->uad_zipcode = $userAddress['uad_zipcode'][$ukey];
						$userAddressModel->uad_mobile = $userAddress['uad_mobile'][$ukey];
						$userAddressModel->uad_user_id = $model->u_id;
						$userAddressModel->save();						
					}
				}
				if(!empty($_POST['user_cources'])){
					foreach ($_POST['user_cources'] as $ckey => $cid) {
						$usModel = new UserCourses;
						$usModel->cr_user_id = $model->u_id;
						$usModel->cr_category_id = $cid;
						$usModel->save();
					}
				}
				Yii::app()->user->setFlash('success','User added successfully.');					
				$this->redirect(array('userlist'));
			}else{
				$t = $model->getErrors();	
				if(!empty($t)){					
					Yii::app()->user->setFlash('error','Please fill all the required fields.');	
				}
				else{
					Yii::app()->user->setFlash('error','Error in save, Please try again.');	
				}
			}
		}

		$criteria=new CDbCriteria;
		$criteria->order = 'cnt_name ASC';

		$userAddressModel = new UserAddress;

		$countriesData = Countries::model()->findAll($criteria);
		$countries = CHtml::listData($countriesData,'cnt_id','cnt_name');
		$criteria=new CDbCriteria;
		$criteria->order = "st_name ASC";
		$criteria->condition = "st_cnt_id=:st_cnt_id";
		$criteria->params = array(':st_cnt_id' => 105);					
		$statesData = States::model()->findAll($criteria);
		$states1 = CHtml::listData($statesData,'st_id','st_name');
		$states2 = CHtml::listData($statesData,'st_id','st_name');


		$this->render('add',array(
			'model'=>$model,	
			'userAddressModel' => $userAddressModel,
			'countries' => $countries,
			'states1' => $states1,
			'states2' => $states2		
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
		$this->setPageTitle('Dashboard');
		$this->render('index');
	}
	
	public function actionUserlist() {
		
		$model = new User('userlist');
		if(isset($_GET['User'])) {
	        $model->attributes =$_GET['User'];
	   	}
	   	
	   	Yii::import('ext.phpexcelreader.JPhpExcelReader');
		if(!empty($_POST)){
			if(!empty($_FILES['importexcel']['name'])){
				$name = $_FILES['importexcel']['name'];
				$tmp_name = $_FILES['importexcel']['tmp_name'];
				$extension = pathinfo($name)['extension'];
				if($extension=='xls'){
					$file_name = uniqid().'.'.$extension;
					$dir_name 	= Yii::getPathOfAlias('webroot').'/storage/excel/';
					$file_path 	= $dir_name.$file_name;
					if(move_uploaded_file($tmp_name, $file_path)){
						$data=new JPhpExcelReader($file_path);
						prd($data->sheets[0]['cells']);
						if(!empty($data->sheets[0]['cells'])){
							foreach ($data->sheets[0]['cells'] as $key => $columnArr) {
								if($key>1){
									$uModel = new User;
									$uModel->u_first_name = $columnArr[1];
									$uModel->u_last_name = $columnArr[2];
									$uModel->u_email = $columnArr[3];
									$uModel->u_password = $columnArr[4];
									$uModel->u_repeat_password = $columnArr[4];
									$uModel->u_status = 1;
									$uModel->u_gender = $columnArr[11];
									$uModel->u_mail_verify = 1;
									$uModel->isNewRecord = true;
									$uModel->terms_conditions = 1;
									$errors = $uModel->getErrors();
									if(!empty($columnArr[12])){
										$aDate = explode('/',$columnArr[12]);
										$uModel->u_addmission_date = $aDate[2]."-".$aDate[1]."-".$aDate[0];
									}
									if($uModel->save()){
										$userAddressModel = new UserAddress;
										$userAddressModel->uad_type = 1;
										$userAddressModel->uad_add1 = $columnArr[5];;
										$userAddressModel->uad_add2 = $columnArr[6];
										$userAddressModel->uad_country_id = 105;
										$userAddressModel->uad_state_id = $columnArr[7];	;
										$userAddressModel->uad_city = $columnArr[8];
										$userAddressModel->uad_zipcode = $columnArr[9];
										$userAddressModel->uad_mobile = $columnArr[10];
										$userAddressModel->uad_user_id = $uModel->u_id;
										$userAddressModel->save();						
									}
								}
							}
							Yii::app()->user->setFlash('success','Imported successfully.');	
							unlink($file_path);					
						}else{
							Yii::app()->user->setFlash('error','Invalid excel file.');						
						}
					}
				}else{
					Yii::app()->user->setFlash('error','Invalid excel file.');						
				}
			}else{
				Yii::app()->user->setFlash('error','Invalid excel file.');					
			}
			$this->redirect(array('userlist'));	
		}

	   	$params =array('model'=>$model);
		
		 if(!isset($_GET['ajax'])) {
			 	$this->render('userlist', $params);
		 } else {
  	  			$this->renderPartial('userlist', $params);
		 }		
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
		if($model===null || $id == Yii::app()->adminUser->id)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionLogin(){		
		//echo User::model()->hashPassword('123456');	exit;
		$this->layout = '/layouts/login';
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model = new AdminLoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{ 
			$model->attributes=$_POST['AdminLoginForm'];
			$model->setAttributes(array(
				'loginas'=>0
			));
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(array('/admin'));
			}else{
					
			}
		}
		
		$this->render('login',array(
			'model'=>$model,
		));	
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(array('logout'));
	}

		
	public function actionProfile(){
		$model=User::model()->findByPk(Yii::app()->adminUser->id);
		$model->scenario = 'adminprofile';		
		if(isset($_POST['User']))
		{
			unset($model->u_password);
			$model->attributes=$_POST['User'];				
			if($model->validate() && $model->save()){
				Yii::app()->user->setFlash('success','Profile updated successfully.');
				$this->refresh();
			}else{
				$t = $model->getErrors();
				if(!empty($t)){
					Yii::app()->user->setFlash('error','Please validate all the fields.');
				}
				else
					Yii::app()->user->setFlash('error','Error in save, Please try again.');
			}
		}		
		$this->render('profile',array('model'=>$model));		
	}
	
	public function actionChangepassword(){
		$model=User::model()->findByPk(Yii::app()->adminUser->id);
		$model->scenario = 'changepassword';
		if(isset($_POST['User'])){
			$model->attributes=$_POST['User'];			
			if($model->validate() && $model->save()){				
				Yii::app()->user->setFlash('success','Password updated successfully.');
				$this->redirect(array('index'));
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
	
	
	public function actionStatus($id,$status){
		$user = User::model()->findByPk($id);
		if($user){
			$newstatus = ($status==1)?0:1;
			$user->u_status = $newstatus;
			$user->save();

		}else{
			throw new CHttpException(404,'Requested User Not Exists.');
		}
		Yii::app()->end();		
	}

	
	public function actionForgotpassword(){
		$this->layout = '/layouts/login';
		$model = new ForgotPassword();
		$model->scenario = 'adminpass';
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
						$this->redirect(array('/admin/user/login'));
					}else{
						Yii::app()->user->setFlash('success','Error in setting the reset key.');
					}
				}
			}
		}
		$this->render('forgotpassword',array('model'=>$model));		
	}

	public function actionViewaddress($id){
		$criteria=new CDbCriteria;
		$criteria->order = 'uad_type ASC';
		$criteria->condition = 'uad_user_id=:uad_user_id';
		$criteria->params = array(':uad_user_id' => $id);
		$model = UserAddress::model()->findAll($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('viewaddress',array('model' => $model));
	}
}
