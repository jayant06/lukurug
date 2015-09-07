<?php

class CmspageController extends Controller
{
	public $layout='/layouts/main';
	public function actionEdit($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cmspage']))
		{
			$model->attributes=$_POST['Cmspage'];
			if($model->validate() && $model->save()){
				Yii::app()->user->setFlash('success','Cmspage updated successfully.');	
				$this->redirect(array('index'));
			}else{
				$t = $model->getErrors();				
				if(!empty($t)){					
					Yii::app()->user->setFlash('error','Please fill all the required fields.');	
				}
				else
					Yii::app()->user->setFlash('error','Error in update, Please try again.');	
			}

		}

		$this->render('edit',array(
			'model'=>$model,
		));
	}

	public function actionIndex()
	{
		$model = new Cmspage('search');

		if(isset($_GET['Cmspage']))
			$model->attributes =$_GET['Cmspage'];

		$params =array(
			'model'=>$model,			
		);

		if(!isset($_GET['ajax'])) 
			$this->render('index', $params);
		else  
			$this->renderPartial('index', $params);
	}	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cmspage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cmspage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cmspage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cmspage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAccessdenied()
	{
		$this->render('accessdenied');
	}
}