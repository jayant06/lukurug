<?php

class DefaultController extends Controller
{
	
	public $layout='column2';
	
	
	
	public function actionIndex()
	{
		$this->layout='column1';
		$model = new AuthItem();
		$child = new AuthItemchild();
		
		if(isset($_POST['AuthItem'])){	
			$model->attributes = $_POST['AuthItem'];
			
			$model->type = 1;
			$child->attributes=$_POST['AuthItemchild'];
			$child->child = $model->name;
			$save = $child->validate() && $model->validate();			
			if($save){
				$auth = Yii::app()->authManager;
				$auth->createTask($model->name,$model->description,$model->bizrule,$model->data);
				$child->attributes=$_POST['AuthItemchild'];
				
				if($child->validate()){					
					$auth->addItemChild($child->parent,$child->child);
				}
				
				Yii::app()->user->setFlash('success','Action allowed successfully.');	
				$this->redirect(array('index'));
			}else{
				Yii::app()->user->setFlash('error','Error in saving.');		
			}
		}
		
		$role = AuthItem::model()->findAll(array('condition'=>'type=2'));
		
		$this->render('index',array('model'=>$model,'role'=>$role,'child'=>$child));
	}
	
	public function actionAuthItem()
	{
		$model = new AuthItem();
		
		if(isset($_POST['AuthItem'])){			
			$model->attributes = $_POST['AuthItem'];
			$save = false;
			if(strcmp($model->type,'task')==0)
			{
				$auth=Yii::app()->authManager;
				$save = $auth->createTask($model->name,$model->description,$model->bizrule,$model->data);
			}
			elseif(strcmp($model->type,'role')==0)
			{
				$auth=Yii::app()->authManager;
				$save = $auth->createRole($model->name,$model->description,$model->bizrule,$model->data);
			}
			elseif(strcmp($model->type,'operation')==0)
			{
				$auth=Yii::app()->authManager;
				$save = $auth->createOperation($model->name,$model->description,$model->bizrule,$model->data);
			}
			if($save){
				Yii::app()->user->setFlash('success','Data save successfully.');	
			}else{
				Yii::app()->user->setFlash('error','Error in saving.');		
			}
		}
		
		$this->render('create',array('model'=>$model));
	}
	
	public function actionCreatechild(){
		$model = new AuthItemchild();
		
		if(isset($_POST['AuthItemchild']))
		{
			$model->attributes=$_POST['AuthItemchild'];
			if($model->validate())
			{
				//$this->saveModel($model);
				//$this->redirect(array('view','parent'=>$model->parent, 'child'=>$model->child));
				$auth = Yii::app()->authManager;
				$auth->addItemChild($model->parent,$model->child);
			}
		}
		
		$this->render('createchild',array('model'=>$model));	
	}
	
	public function actionAssignment(){
		$model = new Authassignment();
		
		if(isset($_POST['Authassignment']))
		{
			$model->attributes=$_POST['Authassignment'];
			if($model->validate())
			{
				//$this->saveModel($model);
				//$this->redirect(array('view','itemname'=>$model->itemname, 'userid'=>$model->userid));
				$auth = Yii::app()->authManager;
				$auth->assign($model->itemname,$model->userid,$model->bizrule,$model->data);
			}
		}
		
		$user = User::model()->findAll();
		$item = AuthItem::model()->findAll(array('condition'=>'type=2'));
		
		$this->render('assignment',array('model'=>$model,'user'=>$user,'item'=>$item));	
	}
	
	/*public function actionIndex()
	{
		$this->render('index');
	}*/
	
}