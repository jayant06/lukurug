<?php

class UserMeasurementsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout=false;

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($type)
	{
		if($type===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$model=new UserMeasurements;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserMeasurements']))
		{
			$user_id = Yii::app()->user->id;
			$return['error'] = 1;
			$return['msg'] = 'Required fields should not blank.';
			$model->attributes=$_POST['UserMeasurements'];
			$model->umr_user_id = $user_id;
			//$error = CActiveForm::validate($model);
			//prd($error);
			if($model->save()){
				$return['error'] = 0;
				$return['msg'] = 'Save Successfully.';
			}
			echo json_encode($return,true);
			Yii::app()->end();
		}

		$this->render('_form',array(
			'model'=>$model,
			'type' => $type
		));
	}

	/**
	 * View a new model.
	 */
	public function actionView($umid,$type)
	{
		$this->layout = false;
		if($type===null && $umid===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$model=$this->loadModel($umid);
		$this->render('view',array(
			'model'=>$model,
			'type' => $type
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($umid,$type)
	{
		$model=$this->loadModel($umid);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserMeasurements']))
		{
			$return['error'] = 1;
			$return['msg'] = 'Required fields should not blank.';
			$model->attributes=$_POST['UserMeasurements'];
			if($model->save()){
				$return['error'] = 0;
				$return['msg'] = 'Save Successfully.';
			}
			echo json_encode($return,true);
			Yii::app()->end();
		}

		$this->render('_form',array(
			'model' => $model,
			'type' => $type
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$return['error'] = 1;
			$return['msg'] = 'Something went wrong.';
			// we only allow deletion via POST request
			if($this->loadModel($id)->delete()){
				$return['error'] = 0;
				$return['msg'] = 'Delete Successfully.';
			}
			echo json_encode($return,true);
			Yii::app()->end();			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UserMeasurements');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=UserMeasurements::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-measurements-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSelectedmeasurements($fab_id = NULL){
		$this->layout = false;
		$user_id = Yii::app()->user->id;
		$criteria1=new CDbCriteria;
		$criteria1->condition = "umr_user_id=:umr_user_id";
		$criteria1->params = array(':umr_user_id' => $user_id);
		$userMesurementData = UserMeasurements::model()->findAll($criteria1);
		$userMesurements = array();
		if(!empty($userMesurementData)){
			foreach ($userMesurementData as $umKey => $umArr) {
				$umType = $umArr->umr_type;
				$userMesurements[$umType][] = $umArr;
			}
		}
		$this->render('selectedmeasurements',array('userMesurements' => $userMesurements,'fab_id' => $fab_id));
	}
}
