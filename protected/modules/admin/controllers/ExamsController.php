<?php

class ExamsController extends Controller
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
		$model=new Exams;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Exams'])){
			$model->attributes=$_POST['Exams'];
			if($model->save())
				$this->redirect(array('index'));
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
		$model = $this->loadModel($id);

		if(isset($_POST['Exams'])){
			$model->attributes=$_POST['Exams'];
			if($model->save())
				$this->redirect(array('index'));
		}

		// echo $model->ex_category_id; exit;
		$criteria = new CDbCriteria;
		$criteria->select = array('t.*','(SELECT cat_parent_id FROM {{categories}} WHERE cat_id = t.cat_parent_id) AS main_cat_id');
		$criteria->order = 'cat_name';
		$criteria->condition = 'cat_id=:cat_id';
		$criteria->params = array(':cat_id'=>$model->ex_category_id);
		$CategoryData = Categories::model()->find($criteria);
		/*echo '<pre> dd';
		print_r($CategoryData->main_cat_id);
		exit;*/

		// $mainCategories = CHtml::listData($mainCategoryData,'cat_id','cat_name');

		$sub_cat_id = $CategoryData->cat_parent_id;
		$main_cat_id = $CategoryData->main_cat_id;

		// SUB CATEGORY LIST
		$criteria = new CDbCriteria;
		$criteria->select = array('t.*','(SELECT cat_parent_id FROM {{categories}} WHERE cat_id = t.cat_parent_id) AS main_cat_id');
		$criteria->order = 'cat_name';
		$criteria->condition = 'cat_parent_id=:cat_id';
		$criteria->params = array(':cat_id'=>$main_cat_id);
		$SubCategoryData = Categories::model()->findAll($criteria);
		$SubCategories = CHtml::listData($SubCategoryData,'cat_id','cat_name');

		$maincategories = 
		$subcategories = 

		$this->render('update',array(
			'model'=>$model,
			'sub_cat_id'=>$sub_cat_id,
			'main_cat_id'=>$main_cat_id,
			'SubCategories'=>$SubCategories
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

	public function actionStatus(){
		$this->layout = false;
		if(Yii::app()->request->isAjaxRequest){
			$return['msg'] = 'Status was not updated successfully.';
			$return['error'] = 2;
			$return['data'] = '';
			if(Yii::app()->request->getPost('ex_id') && Yii::app()->request->getPost('ex_id')>0){
				$model = Exams::model()->findByPk(Yii::app()->request->getPost('ex_id'));
				// print_r($model);
				if(!empty($model)){
					$model->ex_status = Yii::app()->request->getPost('status');
					if($model->save()){
						$return['msg'] = 'Status updated successfully.';
						$return['error'] = 0;
					}else{
						$return['msg'] = 'Status was not updated successfully.';
						$return['error'] = 1;
					}
				}
			}
			echo CJSON::encode($return);
		}else{
			$this->redirect(array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Exams;
		if(isset($_GET['Exams'])) {
	        $model->attributes =$_GET['Exams'];
	   	}
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
		$model=Exams::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='exams-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
