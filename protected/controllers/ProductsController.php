<?php
class ProductsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * Lists all products.
	 */
	public function actionIndex($id = NULL)
	{
		$model = new Items;
		if(!empty($id))
			$model->searchCriteria['catid'] = $id;
		$this->render('index',array(
			'model' => $model,
		));
	}

	public function actionView(){ 
		$slug = Yii::app()->request->getParam('slug');
		$criteria=new CDbCriteria;
		$criteria->condition = 'itm_slug=:itm_slug';
		$criteria->params = array(':itm_slug' => $slug);
		$model = Items::model()->find($criteria);
		$this->render('view',array('model' => $model));
	}	

	public function actionVieworders($id){
		$user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;
		$criteria->condition = "citm_cart_id=:citm_cart_id AND cart_user_id=:cart_user_id";
		$criteria->params = array(':citm_cart_id' => $id,':cart_user_id' => $user_id);
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

		$fabrics = array();
		if(!empty($fabricDetails)){
			foreach ($fabricDetails as $key2 => $arr) {
				$fabId = $arr->fab_id;
				$fabrics[$fabId] = $arr;
			}
		}

		$buttons = CHtml::listData($buttonDetails,'but_id','but_name');
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('vieworders',array('model' => $model,'fabrics' => $fabrics,'buttons' => $buttons,'customizatiosData' => $customizatiosData));
	}
}
