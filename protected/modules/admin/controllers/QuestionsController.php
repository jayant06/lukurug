<?php
class QuestionsController extends Controller
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
		$model=new Questions;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Questions']))
		{
			$model->attributes=$_POST['Questions'];
			$type = $_POST['Questions']['qt_type'];
			if($model->save()){
				if(!empty($_POST['qoptions'])){
					foreach ($_POST['qoptions'] as $optKey => $optName) {
						if(!empty($optName)){
							$optionModel = new QuestionsOptions;
							$optionModel->qto_name = $optName;
							$optionModel->qto_question_id = $model->qt_id;

							if(!empty($_POST['rightansh'][$optKey]))
								$optionModel->qto_right_ans = 1;
							else
								$optionModel->qto_right_ans = 0;

							if($type==2){
								if(!empty($_FILES['qfile']['name'][$optKey])){
									$imgName = $this->imageUpload($_FILES['qfile']['name'][$optKey],$_FILES['qfile']['tmp_name'][$optKey],'qoptions');
									$optionModel->qto_image = $imgName;
								}
							}
							$optionModel->save();
						}
					}					
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

		if(isset($_POST['Questions']))
		{
			$model->attributes=$_POST['Questions'];
			$type = $_POST['Questions']['qt_type'];
			if($model->save()){
				if(!empty($_POST['qoptions'])){
					$criteria=new CDbCriteria;
					$criteria->condition = "qto_question_id=:qto_question_id";
					$criteria->params = array(':qto_question_id' => $model->qt_id);
					QuestionsOptions::model()->deleteAll($criteria);
					foreach ($_POST['qoptions'] as $optKey => $optName) {
						if(!empty($optName)){
							$optionModel = new QuestionsOptions;
							$optionModel->qto_name = $optName;
							$optionModel->qto_question_id = $model->qt_id;

							if(!empty($_POST['rightansh'][$optKey]))
								$optionModel->qto_right_ans = 1;
							else
								$optionModel->qto_right_ans = 0;

							if($type==2){
								if(!empty($_FILES['qfile']['name'][$optKey])){
									$imgName = $this->imageUpload($_FILES['qfile']['name'][$optKey],$_FILES['qfile']['tmp_name'][$optKey],'qoptions');
									$optionModel->qto_image = $imgName;
								}else{
									unset($optionModel->qto_image);
								}
							}
							pr($optionModel->attributes);
							$optionModel->save();
						}
					}	
					exit;									
				}
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
		$model = new Questions;
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
		$model=Questions::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='questions-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeleteoption(){
		$deleted = 0;
		if(!empty($_POST)){
			$qtid = $_POST['qtid'];
			if(!empty($qtid)){
				$model=QuestionsOptions::model()->findByPk($qtid);
				if($model!==null){
					if($model->delete()){
						$deleted = 1;
					}
				}
			}
		}
		echo $deleted;
		Yii::app()->end();
	}
}
