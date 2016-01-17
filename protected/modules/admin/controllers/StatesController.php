<?php

class StatesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new States;
		$model->st_cnt_id = 105;
		if(isset($_GET['States'])) {
	        $model->attributes =$_GET['States'];
	   	}
		$this->render('index',array(
			'model'=>$model,
		));
	}	
}
