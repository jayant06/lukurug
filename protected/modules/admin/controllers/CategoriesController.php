<?php
class CategoriesController extends Controller
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
		$model=new Categories;
		if(!empty($_REQUEST['type'])){
			$model->categoryType = $_REQUEST['type'];
			if($_REQUEST['type']==2)
	   			$model->cat_parent_type = 2;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
			$model->attributes=$_POST['Categories'];
			if($model->save()){
				$model->cat_code = 'C00'.$model->cat_id;
				$model->isNewRecord = false;
				$model->save();
				$this->redirect(array('index','type' => $_REQUEST['type']));
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
		if(empty($model->cat_code))
			$model->cat_code = $model->generateCatCode();
		if(!empty($_REQUEST['type'])){
			$model->categoryType = $_REQUEST['type'];
			if($_REQUEST['type']==2)
	   			$model->cat_parent_type = 2;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
			$model->attributes=$_POST['Categories'];
			if($model->save())
				$this->redirect(array('index','type' => $_REQUEST['type']));
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
		$model = new Categories;
		if(isset($_GET['Categories'])) {
	        $model->attributes =$_GET['Categories'];
	   	}
	   	if(!empty($_REQUEST['type']))
	   		$model->categoryType = $_REQUEST['type'];

	   	if(isset($_GET['course_id'])) {
	   		$model->cat_parent_id = $_GET['course_id'];
	        $this->renderPartial('index',array(
				'model'=>$model,
			));
	   	}else{
	   		$this->render('index',array(
				'model'=>$model,
			));
	   	}	   	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Categories::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSubcategories(){
		$subcatIds = array();
		if(!empty($_POST['maincatid'])){
			$criteria=new CDbCriteria;
			$criteria->order = 'cat_name';
			$criteria->condition = "cat_parent_id='".$_POST['maincatid']."'";
			$categories = Categories::model()->findAll($criteria);
			if(!empty($categories)){
				$i = 0;
				foreach ($categories as $key => $catArr) {
					$subcatIds[$i]['id'] = $catArr->cat_id;
					$subcatIds[$i]['name'] = $catArr->cat_name;					
					$i++;
				}
			}
		}
		echo json_encode($subcatIds);
		Yii::app()->end();
	}
}
