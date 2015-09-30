<?php
class ButtonsController extends Controller
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
	public function actionCreate()
	{
		$model=new Buttons;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Buttons']))
		{
			$model->attributes=$_POST['Buttons'];
			if($model->save()){
				if(!empty($_FILES['Buttons']['name']['but_image'])){
					$pathinfo 	= pathinfo($_FILES['Buttons']['name']['but_image']);
					$image_name = 'button_'.$model->but_id.".".$pathinfo['extension'];
					$this->imageUpload($_FILES['Buttons']['name']['but_image'],$_FILES['Buttons']['tmp_name']['but_image'],'buttons',$image_name);
					$model->but_image = $image_name;
					$model->save();
				}
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Buttons']))
		{
			$model->attributes=$_POST['Buttons'];
			if(!empty($_FILES['Buttons']['name']['but_image'])){
				$pathinfo 	= pathinfo($_FILES['Buttons']['name']['but_image']);
				$image_name = 'button_'.$id.".".$pathinfo['extension'];
				$this->imageUpload($_FILES['Buttons']['name']['but_image'],$_FILES['Buttons']['tmp_name']['but_image'],'buttons',$image_name);
				$model->but_image = $image_name;				
			}
			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
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
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Buttons;
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Buttons::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='buttons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
