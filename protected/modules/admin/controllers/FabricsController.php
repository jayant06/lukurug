<?php
class FabricsController extends Controller
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
		$model=new Fabrics;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Fabrics']))
		{
			$model->attributes=$_POST['Fabrics'];
			if(!empty($_FILES['Fabrics']['name']['fab_image']))
				$image_name = $this->imageUpload($_FILES['Fabrics']['name']['fab_image'],$_FILES['Fabrics']['tmp_name']['fab_image'],'fabrics');
			if(!empty($image_name))
				$model->fab_image = $image_name;
			else
				unset($model->fab_image);
			
			if($model->save()){
				$dir_name 			= Yii::getPathOfAlias('webroot').'/storage/fabrics/';
				if(!empty($model->fab_for)){
					if($model->fab_for==1){
						// fro shirt
						mkdir($dir_name.$model->fab_id, 0777);
						mkdir($dir_name.$model->fab_id."/back", 0777);
						mkdir($dir_name.$model->fab_id."/collar", 0777);
						mkdir($dir_name.$model->fab_id."/cuff", 0777);
						mkdir($dir_name.$model->fab_id."/front", 0777);
						mkdir($dir_name.$model->fab_id."/placket", 0777);
						mkdir($dir_name.$model->fab_id."/pocket", 0777);
						mkdir($dir_name.$model->fab_id."/sleeve", 0777);
						mkdir($dir_name.$model->fab_id."/yoke", 0777);
					}else if($model->fab_for==2){
						// fro trouser	
						mkdir($dir_name.$model->fab_id, 0777);
						mkdir($dir_name.$model->fab_id."/back", 0777);
						mkdir($dir_name.$model->fab_id."/bottom_style", 0777);
						mkdir($dir_name.$model->fab_id."/front", 0777);
						mkdir($dir_name.$model->fab_id."/pleated", 0777);
						mkdir($dir_name.$model->fab_id."/side_pocket", 0777);
						mkdir($dir_name.$model->fab_id."/lining", 0777);
					}else if($model->fab_for==3){
						// for blazer
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

		if(isset($_POST['Fabrics']))
		{
			$model->attributes=$_POST['Fabrics'];
			if(!empty($_FILES['Fabrics']['name']['fab_image']))
				$image_name = $this->imageUpload($_FILES['Fabrics']['name']['fab_image'],$_FILES['Fabrics']['tmp_name']['fab_image'],'fabrics');
			if(!empty($image_name))
				$model->fab_image = $image_name;
			else
				unset($model->fab_image);
			
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
		$model = new Fabrics;
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionAddbuttons($id){
		if(empty($id))
			$this->redirect(array('index'));
		$buttons = Buttons::model()->findAll();
		$model = $this->loadModel($id);

		$criteria=new CDbCriteria;	
		$criteria->condition = 'fbt_fabric_id=:fbt_fabric_id';
		$criteria->params = array(':fbt_fabric_id' => $id);

		if(!empty($_POST)){
			if(!empty($_POST['buttonids'])){
				FabricButtons::model()->deleteAll($criteria);
				foreach ($_POST['buttonids'] as $key => $buttonId) {
					$fabButtonModel = new FabricButtons;
					$fabButtonModel->fbt_fabric_id = $id;
					$fabButtonModel->fbt_button_id = $buttonId;
					$fabButtonModel->save();
				}
			}
			Yii::app()->user->setFlash('success','Assigned successfully.');	
			$this->redirect(array('addbuttons','id' => $id));
		}
		
		$fabriButtonsData = FabricButtons::model()->findAll($criteria);
		$fabriButtons = CHtml::listData($fabriButtonsData,'fbt_id','fbt_button_id');
		$this->render('addbuttons',array('buttons' => $buttons,'model' => $model,'fabriButtons' => $fabriButtons));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Fabrics::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='fabrics-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionUploadcustomizeimages($id){
		$model=$this->loadModel($id);
		$this->render('uploadcustomizeimages',array('model' => $model,'fabricId'=>$id));
	}

	public function actionUploadimages(){
		$this->layout = false;
		$ret['file'] = '';
		$ret['error'] = 1;
		$ret['msg'] = 'Error in file upload.';
		if(!empty($_POST['option']) && !empty($_POST['suboption']) && !empty($_POST['fab_for']) && !empty($_POST['fabid'])){
			$fabid 		= $_POST['fabid'];
			$fab_for 	= $_POST['fab_for'];
			$option 	= $_POST['option'];
			$suboption 	= $_POST['suboption'];
			if(isset($_FILES["myfile"])){
				$name 			= $_FILES["myfile"]["name"];
				$tmp_name 		= $_FILES["myfile"]["tmp_name"];				
				$ret['file'] 	= $this->imageuploadandstatus($fabid,$fab_for,$option,$suboption,$name,$tmp_name,true);
				$ret['error'] 	= 0;
				$ret['msg'] 	= '';				
			}
		}
		echo json_encode($ret);exit;
	}

	public function actionImageexist(){
		$this->layout = false;
		$ret['file'] = '';
		if(!empty($_GET['option']) && !empty($_GET['suboption']) && !empty($_GET['fab_for']) && !empty($_GET['fabid'])){
			$fabid 			= $_GET['fabid'];
			$fab_for 		= $_GET['fab_for'];
			$option 		= $_GET['option'];
			$suboption 		= $_GET['suboption'];
			$dir_name 		= Yii::getPathOfAlias('webroot').'/storage/';
			$filename		= $this->imageuploadandstatus($fabid,$fab_for,$option,$suboption);
			if(file_exists($dir_name.$filename)){
				$ret['file'] = $filename;				
			}			
		}
		echo json_encode($ret);exit;	
	}

	private function imageuploadandstatus($fabid,$fab_for,$option,$suboption,$name = NULL,$tmp_name = NULL,$is_upload = false){
		$dir_name 			= 'fabrics/'.$fabid;

		if($fab_for==1){ //Shirt
			$fabFolderBack 		= $dir_name."/back/";
			$fabFolderCollor 	= $dir_name."/collar/";
			$fabFolderCuff 		= $dir_name."/cuff/";
			$fabFolderFront 	= $dir_name."/front/";
			$fabFolderPlacket 	= $dir_name."/placket/";
			$fabFolderPocket 	= $dir_name."/pocket/";
			$fabFolderSleeve 	= $dir_name."/sleeve/";
			$fabFolderYoke 		= $dir_name."/yoke/";
			switch ($option) {
				case 1: //Sleeve
					$dname = $fabFolderSleeve;
					if($suboption==1){ //Short
						$image_name = 'sleeves_short.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderSleeve,$image_name);
					}else if($suboption==2){ //Long
						$image_name = 'sleeves_full.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderSleeve,$image_name);
					}else if($suboption==3){ //Rolled Up
						$image_name = 'sleeves_rolled_up.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderSleeve,$image_name);
					}
					break;
				case 2: //Collar
					$dname = $fabFolderCollor;
					if($suboption==1){ //Bottom Down
						$image_name = 'collar_button_down.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}else if($suboption==2){ //Classic
						$image_name = 'collar_classic.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}else if($suboption==3){ //Short Spread
						$image_name = 'collar_short_spread.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}else if($suboption==4){ //Spread 
						$image_name = 'collar_spread.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}else if($suboption==5){ //Tall Spread
						$image_name = 'collar_tall_spread.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}else if($suboption==6){ //Chinese
						$image_name = 'collar_chinese.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCollor,$image_name);
					}
					break;
				case 3: //Cuff
					$dname = $fabFolderCuff;
					if($suboption==1){ //Left Single Button
						$image_name = 'cuff_left_single_button.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}else if($suboption==2){ //Right Single Button
						$image_name = 'cuff_right_single_button.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}else if($suboption==3){ //Left Double Button
						$image_name = 'cuff_left_double_button.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}else if($suboption==4){ //Right Double Button
						$image_name = 'cuff_right_double_button.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}else if($suboption==5){ //Left French Cuff
						$image_name = 'cuff_left_french.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}else if($suboption==6){ //Right French Cuff
						$image_name = 'cuff_right_french.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderCuff,$image_name);
					}
					break;
				case 4: //Placket
					$dname = $fabFolderPlacket;
					if($suboption==1){ //American
						$image_name = 'placket_american.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPlacket,$image_name);
					}else if($suboption==2){ //French
						$image_name = 'placket_french.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPlacket,$image_name);
					}else if($suboption==3){ //Hidden
						$image_name = 'placket_hidden.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPlacket,$image_name);
					}
					break;
				case 5: //Pocket
					$dname = $fabFolderPocket;
					if($suboption==1){ //Left Round
						$image_name = 'pocket_left_round.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==2){ //Right Round
						$image_name = 'pocket_right_round.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==3){ //Left Square
						$image_name = 'pocket_left_square.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==4){ //Right Round
						$image_name = 'pocket_right_square.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==5){ //Left Angled
						$image_name = 'pocket_left_angled.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==6){ //Right Angled
						$image_name = 'pocket_right_angled.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==7){ //Left Vshape
						$image_name = 'pocket_left_vshape.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==8){ //Right Vshape
						$image_name = 'pocket_right_vshape.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==9){ //Left Flap
						$image_name = 'pocket_left_vshape_with_flap.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}else if($suboption==10){ //Right Flap
						$image_name = 'pocket_right_vshape_with_flap.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPocket,$image_name);
					}
					break;
				case 6: //Back Detail
					$dname = $fabFolderBack;
					if($suboption==1){ //No Pleats
						$image_name = 'back_no_pleats.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==2){ //Box Pleat
						$image_name = 'back_box_pleats.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==3){ //Side Pleat
						$image_name = 'back_side_pleats.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==4){ //Back Yock
						$image_name = 'back_yoke.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}
					break;
				case 7: //Bottom Cut
					$dname = $fabFolderFront;
					if($suboption==1){ //Round
						$image_name = 'front_shirt_bottom_long.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderFront,$image_name);
					}else if($suboption==2){ //Straight
						$image_name = 'front_shirt_bottom_straight.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderFront,$image_name);
					}
					break;
				case 8: //Front Yoke
					$dname = $fabFolderYoke;
					if($suboption==1){ // Center Front Yoke
						$image_name = 'back_yock_center_front.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderYoke,$image_name);
					}else if($suboption==2){ // Side Front Yoke
						$image_name = 'back_yock_side_front.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderYoke,$image_name);
					}
					break;					
			}
		}else if($fab_for==2){ //Trousre
			$fabFolderFront 	= $dir_name."/front/";
			$fabFolderPleated 	= $dir_name."/pleated/";
			$fabFolderSidePocket = $dir_name."/side_pocket/";			
			$fabFolderBack 		= $dir_name."/back/";
			$fabFolderBottomStyle = $dir_name."/bottom_style/";
			$fabFolderLining = $dir_name."/lining/";
			switch ($option) {
				case 1: //Front
					$dname = $fabFolderFront;
					if($suboption==1){ //Trouser
						$image_name = 'front_trouser.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderFront,$image_name);
					}
					break;
				case 2: //pleated
					$dname = $fabFolderPleated;
					if($suboption==1){ //Single Pleated
						$image_name = 'single_pleated.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPleated,$image_name);
					}else if($suboption==2){ //Double Pleated
						$image_name = 'double_pleated.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderPleated,$image_name);
					}else if($suboption==3){ //Flat Front Pleated
						// No need to upload any image
					}
					break;
				case 3: //Side Pocket
					$dname = $fabFolderSidePocket;
					if($suboption==1){ //Slant Pocket
						$image_name = 'slant_pocket.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderSidePocket,$image_name);
					}else if($suboption==2){ //Straight Pocket
						$image_name = 'straight_pocket.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderSidePocket,$image_name);
					}
					break;
				case 4: //Back Pocket
					$dname = $fabFolderBack;
					if($suboption==1){ //Flap Left
						$image_name = 'back_left_pocket_flap.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==2){ //Flap Right
						$image_name = 'back_right_pocket_flap.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==3){ //Double Welp Pocket Left
						$image_name = 'back_left_pocket_doublewelt.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==4){ //Double Welp Pocket Right
						$image_name = 'back_right_pocket_doublewelt.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}else if($suboption==5){ //Back side trouser
						$image_name = 'back_pockets.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBack,$image_name);
					}
					break;
				case 5: //Bottom Style
					$dname = $fabFolderBottomStyle;
					if($suboption==1){ //straight_hem
						$image_name = 'straight_hem.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}else if($suboption==2){ //shoe_cut
						$image_name = 'shoe_cut.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}else if($suboption==3){ //turn_up
						$image_name = 'turn_up.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}
					break;	
				case 6: //Lining
					$dname = $fabFolderLining;
					if($suboption==1){ //no_lining
						$image_name = 'no_lining.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}else if($suboption==2){ //half_front_lining
						$image_name = 'half_front_lining.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}else if($suboption==3){ //half_front_and_back_lining
						$image_name = 'half_front_and_back_lining.png';
						if($is_upload==true)
							$this->imageUpload($name,$tmp_name,$fabFolderBottomStyle,$image_name);
					}
					break;	
			}
		}else if($fab_for==3){ //Blazer

		}

		return $dname.$image_name;
	}
}
