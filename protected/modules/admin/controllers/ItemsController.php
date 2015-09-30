<?php

class ItemsController extends Controller
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
		$model=new Items;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Items']))
		{
			$model->attributes=$_POST['Items'];
			if(!empty($_FILES['Items']['name']['itm_photo']))
				$image_name = $this->imageUpload($_FILES['Items']['name']['itm_photo'],$_FILES['Items']['tmp_name']['itm_photo'],'products');
			if(!empty($image_name))
				$model->itm_photo = $image_name;
			else
				unset($model->itm_photo);
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Items']))
		{
			$model->attributes=$_POST['Items'];
			if(!empty($_FILES['Items']['name']['itm_photo']))
				$image_name = $this->imageUpload($_FILES['Items']['name']['itm_photo'],$_FILES['Items']['tmp_name']['itm_photo'],'products');
			if(!empty($image_name))
				$model->itm_photo = $image_name;
			else
				unset($model->itm_photo);
			if($model->save())
				$this->redirect(array('index'));
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
		$model = new Items;
		$this->render('index',array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Items::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='items-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionOrders(){
		$model = new Cart;
		$this->render('orders',array('model' => $model));
	}

	public function actionVieworders($id){
		$criteria=new CDbCriteria;
		$criteria->condition = "citm_cart_id=:citm_cart_id";
		$criteria->params = array(':citm_cart_id' => $id);
		$criteria->with = array('cartCartItem','cartItem');
		$criteria->order = 'citm_item_id asc';
		$model=CartItems::model()->findAll($criteria);

		$customizatiosData = array();
		if(!empty($model)){
			foreach ($model as $key => $arrObj) {
				if(!empty($arrObj->citm_customization)){
					$customizations = json_decode($arrObj->citm_customization,true);
					$customizatiosData[$arrObj->citm_id] = $customizations;
				}				
			}
		}

		$fabricDetails = Fabrics::model()->findAll();
		$buttonDetails = Buttons::model()->findAll();

		$buttons = CHtml::listData($buttonDetails,'but_id','but_name');
		$fabrics = array();
		if(!empty($fabricDetails)){
			foreach ($fabricDetails as $key2 => $arr) {
				$fabId = $arr->fab_id;
				$fabrics[$fabId] = $arr;
			}
		}
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('vieworders',array('model' => $model,'fabrics' => $fabrics,'buttons' => $buttons,'customizatiosData' => $customizatiosData));
	}

	public function actionUpdatestatus(){
		if(!empty($_POST['id'])){
			$id = $_POST['id'];
			$value = $_POST['val'];
			$cartModel = Cart::model()->findByPk($id);
			if(!empty($cartModel)){
				$cartModel->cart_order_status = $value;
				$cartModel->save();
			}
			echo 'success';
		}else
			echo 'error';
		exit;
	}
}
