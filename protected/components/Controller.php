<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */

	// this function will be initialize in every controller call which will call initAjaxCsrfToken function
    public function init() {
        parent::init();
        $this->initAjaxCsrfToken();
    }
 
    // this function will work to post csrf token.
    protected function initAjaxCsrfToken() {
 
        Yii::app()->clientScript->registerScript('AjaxCsrfToken', ' $.ajaxSetup({
             data: {"' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '"},
             cache:false
        });', CClientScript::POS_HEAD);        
    }

	public $breadcrumbs=array();
	
	public $tabs;

	public $containercls;

	public $ajaxResponse = array('error'=>0,'message'=>'Error in response.');

	public $loggedusername;

	// TO DEFINE ALL THE FILTERS THAT ARE BEING USED IN THIS CONTROLLER
	public function filters(){
		return array(
			array( 'application.filters.StringFilter'),
		);
	}
	
	public function beforeAction($action){
		
		$controller = ucfirst(strtolower($this->getId()));
		
		$action = ucfirst(strtolower($this->getAction()->getId()));
		
		$module = '';
		
		if(isset($this->module->id)){
			$module = ucfirst($this->module->id);
		}
		
		$operation = $module . $controller . $action;

		//UserPurchaseDetail::model()->license_expire();

		if(Yii::app()->request->isAjaxRequest){
			Yii::app()->clientScript->scriptMap=array('jquery.min.js'=>false);
		}		
		if(!Yii::app()->user->checkAccess($operation)){			
	 		if(Yii::app()->request->isAjaxRequest){				
				Yii::app()->user->setFlash('popupmsg','Not Authorized Action.');
				throw new CHttpException(401,'Unauthorized request.');
				Yii::app()->end();				
			}else{	
				Yii::app()->user->setFlash('popupmsg','Not Authorized Action.');
				$this->redirect(array('site/login'));				
			}
		}elseif(Yii::app()->user->id){
			$user = User::model()->checkStatus();
			if($user->u_status==0){
				Yii::app()->user->logout(false);
				if(Yii::app()->request->isAjaxRequest){				
					Yii::app()->user->setFlash('popupmsg','Your account is deactivated. Please contact site administrator');
					throw new CHttpException(401,'Unauthorized request.');
					Yii::app()->end();				
				}else{	
					Yii::app()->user->setFlash('popupmsg','Your account is deactivated. Please contact site administrator');
					$this->redirect(array('site/login'));				
				}	
			}

			$this->loggedusername = $user->u_first_name.' '.$user->u_last_name;
		}	
		return parent::beforeAction($this->getAction());
	}

	public function sendEmail($templateid = NULL,$to , $request=array(),$subject='',$content=''){
		// /$this->widget('application.extensions.email.debug'); 

		if($templateid!=NULL){
			$Email = new EmailManager();
			$data = $Email::model()->findByPk($templateid);
		    
		    if($data){
			    $subject = $data->em_email_subject;
			    $content = $data->em_email_template;
			}    
		}

		if(!empty($to)){
			//get email template	
		    $default = array(
				'{site_name}' => Yii::app()->params['title'],
			);

			if(isset($request['{verification_link}'])){
				$link = Yii::app()->request->hostInfo.Yii::app()->createUrl("/user/verify", array("key"=>$request['{verification_link}']));
				$request['{verification_link}'] = '<a href="'.$link.'">Confirm Your Account</a>';
			}
			if(isset($request['{reset_link}'])){
				$link = Yii::app()->request->hostInfo.Yii::app()->createUrl("/user/resetpassword", array("key"=>$request['{reset_link}']));
				$request['{reset_link}'] = '<a href="'.$link.'">Reset Password</a>';
			}

			$replace = $request+$default; //ADDING DEFAULT AND PASSED VARIABLE
			
			foreach($replace as $rk=>$rv)
			{
				$content = str_replace($rk,$rv,$content);	
				$subject = str_replace($rk,$rv,$subject);	
			}		  

			/*if($test)
			{
				echo '<strong>TO</strong> : - '.$to;
				echo '<br/>';
				echo '<strong>SUBJECT</strong> : - '.$subject;
				echo '<br/>';
				echo '<strong>MESSAGE</strong> : - '.$content;
				echo '<br/>';			
				return;	
			} */ 

			$mail = new YiiMailer('default', array('message' => $content));
			$mail->setTo($to);
			$mail->setFrom(Yii::app()->params['adminEmail']);
			$mail->setSubject($subject);
			//send email
			if($_SERVER['HTTP_HOST']!='localhost'){
				if($mail->send())
					return true;
				else
					return false;
			}
			else
			{
				return true;
			}
		}else
			return false;
	}
	
	public function sendplainmail($to, $from, $messagedata, $attachment=array(),$test=false){		
		
		$mail = new YiiMailer('default', array('message' => $messagedata->mb_message));
		//set properties
		if(is_object($to))
			$mail->setTo($to->u_email);
		else
			$mail->setTo($to);

		if(is_object($from))
			$mail->setFrom($from->u_email); //$mail->setFrom($model->email, $model->name);
		else
			$mail->setFrom($from);

		$mail->setSubject($messagedata->mb_subject);

		if(!empty($attachment)){
			$file = $attachment['file'];
			$filename = $attachment['filename'];
			$mail->setAttachment(array($file=>$filename));	
		}
		//send
		if ($mail->send() || $_SERVER['HTTP_HOST']=='localhost') {
			$messagedata->save();
			$r = true;
		} else {
			Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
			$r = false;
		}
		return $r;
	}


	public function UploadImage($img,$folder,$oldimage=NULL){
		
		$name = md5(uniqid(rand(), true));
    	$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$path = Yii::getPathOfAlias('webroot').'/storage/'.$folder.'/';
		$filename = $name.'.png';		
		file_put_contents($path.$filename, $data);
		
		//GENERATE SMALL IMAGE
		$newname = $path.'m_'.$name.'.png';
		$image = imagecreatefrompng ( $path.$filename );
		$new_image = imagecreatetruecolor ( 100, 100 ); // new wigth and height
		imagealphablending($new_image , false);
		imagesavealpha($new_image , true);
		imagecopyresampled ( $new_image, $image, 0, 0, 0, 0, 100, 100, imagesx ( $image ), imagesy ( $image ) );
		$image = $new_image;		
		imagealphablending($image , false);
		imagesavealpha($image , true);
		imagepng ($image, $newname);
    	
    	if($oldimage!=NULL){
    		@unlink($path.$oldimage);
    		@unlink($path.'m_'.$oldimage);
    	}

    	return $filename;    	
    }

    public static function getImage($model,$size=NULL){
    	$pre = '';
    	switch ($size) {
    		case 'small':
    			$pre = 'm_';
    			break;
    	}
    	if($model->hasAttribute('u_image')){
    		if(!empty($model->u_image) && file_exists(Yii::getPathOfAlias('webroot').'/storage/user/'.$model->u_image)){
    			$img = Yii::app()->request->baseUrl.'/storage/user/'.$pre.$model->u_image;
    		}else{
    			$img = Yii::app()->request->baseUrl.'/img/signup_pic.png';
    		}
    	}elseif($model->hasAttribute('um_image')){
    		if(!empty($model->um_image) && file_exists(Yii::getPathOfAlias('webroot').'/storage/music/'.$model->um_image)){
    			$img = Yii::app()->request->baseUrl.'/storage/music/'.$pre.$model->um_image;
    		}else{
    			$img = Yii::app()->request->baseUrl.'/img/music_default.png';
    		}
    	}
    	return $img;
    }


    public static function insertSeveral($table, $array_columns)
    {
        $connection = Yii::app()->db;
        $sql = '';
        $params = array();
        $i = 0;
        foreach ($array_columns as $columns) {
            $names = array();
            $placeholders = array();
            foreach ($columns as $name => $value) {
                if (!$i) {
                    $names[] = $connection->quoteColumnName($name);
                }
                if ($value instanceof CDbExpression) {
                    $placeholders[] = $value->expression;
                    foreach ($value->params as $n => $v)
                        $params[$n] = $v;
                } else {
                    $placeholders[] = ':' . $name . $i;
                    $params[':' . $name . $i] = $value;
                }
            }
            if (!$i) {
                $sql = 'INSERT INTO ' . $connection->quoteTableName($table)
                . ' (' . implode(', ', $names) . ') VALUES ('
                . implode(', ', $placeholders) . ')';
            } else {
                $sql .= ',(' . implode(', ', $placeholders) . ')';
            }
            $i++;
        }
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($params);
    }

    public static function highlight($search,$text){    	
		if(trim($search)=='')
			return $text;
		else{
			$search = preg_replace('/[^a-z0-9]/', '', $search);
			return preg_replace('/('.$search.')/i', '<u>\1</u>', $text);
		}
    }
	
	public static function formatduration($time){
		return gmdate('i:s',($time/1000));		
	}

	public static function saletype($key){
		$stype = array('1'=>'Buy Out','2'=>'License','3'=>'Commissioning');
		return $stype[$key];
	}

	public static function offerstatus($key){
		$offerstatus = array('0'=>'New Offer','1'=>'Approved','2'=>'Paid','3'=>'Rejected','4'=>'Cancelled','5'=>'Negotiated','6'=>'Negotiate Accepted','7'=>'Negotiate Rejected','8'=>'Pay Negotiate','9'=>'Paid');
		return $offerstatus[$key];
	}

	public static function statusheader($key){
		$offerstatus = array('0'=>'New Offer','1'=>'Offer Approved','2'=>'Paid for the offer','3'=>'Offer Rejected','4'=>'Offer Cancelled','5'=>'Offer Negotiated','6'=>'Negotiate Accepted','7'=>'Negotiated Offer Rejected','Pending for payment','9'=>'Paid for the negotiate');
		return $offerstatus[$key];
	}		
}
