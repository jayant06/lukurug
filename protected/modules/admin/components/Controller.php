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

	public function filters(){
		return array(
			array( 'application.filters.StringFilter'),
		);
	}
	
	public $ajaxResponse = array('error'=>0,'message'=>'Error in response.');
	
	public $breadcrumbs=array();
	
	public function beforeAction($action){
		
		$controller = ucfirst(strtolower($this->getId()));
		
		$action = ucfirst(strtolower($this->getAction()->getId()));
		
		$module = '';
		
		if(isset($this->module->id)){
			$module = ucfirst($this->module->id);
		}
		
		$operation = $module . $controller . $action;		
		/*if(false){//*/if(!Yii::app()->adminUser->checkAccess($operation)){	
	 		if(Yii::app()->request->isAjaxRequest){				
				Yii::app()->user->setFlash('error','Not Authorized Action.');
				throw new CHttpException(401,'Unauthorized request.');
				Yii::app()->end();
				$content_type_arr = Yii::app()->request->getAcceptTypes();
				$index = preg_match("/application\/json/", $content_type_arr) || preg_match("/application\/jsonp/", $content_type_arr);								
			}else{					
				if(Yii::app()->adminUser->isGuest){					
					$this->redirect(array('/admin/user/login'));															
				}else{
					$this->redirect(array('/admin/accessdenied'));
				}
			}
		}else{
			/*$unreadmessage = ContactMessage::model()->getUnreadCount();
	 		
	 		Yii::app()->params['unread_message'] = $unreadmessage;*/
		}	
		return parent::beforeAction($this->getAction());
	}
	
	public function sendEmail($templateid = NULL,$to , $request=array(),$test=false){
		// /$this->widget('application.extensions.email.debug'); 

		if(!empty($to) && !empty($templateid)){
			//get email template	
			$Email = new EmailManager();
			$data = $Email::model()->findByPk($templateid);
		    
		    $subject = $data->em_email_subject;
		    $content = $data->em_email_template;
		    
		    $default = array(
				'{site_name}' => Yii::app()->params['title'],
			);

			if(isset($request['{verification_link}'])){
				$link = Yii::app()->request->hostInfo.Yii::app()->createUrl("/user/verify", array("key"=>$request['{verification_link}']));
				$request['{verification_link}'] = '<a href="'.$link.'">Confirm Your Account</a></div>';
			}
			if(isset($request['{reset_link}'])){
				$link = Yii::app()->request->hostInfo.Yii::app()->createUrl("/user/resetpassword", array("key"=>$request['{reset_link}']));
				$request['{reset_link}'] = '<a href="'.$link.'">Reset Password</a></div>';
			}

			$replace = $request+$default; //ADDING DEFAULT AND PASSED VARIABLE
			
			foreach($replace as $rk=>$rv)
			{
				$content = str_replace($rk,$rv,$content);	
				$subject = str_replace($rk,$rv,$subject);	
			}		  

			if($test)
			{
				echo '<strong>TO</strong> : - '.$to;
				echo '<br/>';
				echo '<strong>SUBJECT</strong> : - '.$subject;
				echo '<br/>';
				echo '<strong>MESSAGE</strong> : - '.$content;
				echo '<br/>';			
				return;	
			}  

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
		if ($mail->send()) {
			$messagedata->save();
			$r = true;
		} else {
			Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
			$r = false;
		}
		return $r;
	}

	public function adminsendplainmail($to, $from, $subject, $message){		
		
		$mail = new YiiMailer('default', array('message' => $message));
		//set properties
		$mail->setTo($to);
		$mail->setFrom($from);
		$mail->setSubject($subject);
		//send
		if ($mail->send() || $_SERVER['HTTP_HOST']=='localhost') {			
			$r = true;
		} else {			
			$r = false;
		}
		return $r;
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

    public function imageUpload($filename,$tmpname,$type,$name = NULL){
		$return = '';
		if(!empty($filename)){
			$dir_name 	= Yii::getPathOfAlias('webroot').'/storage/'.$type.'/';
			$pathinfo 	= pathinfo($filename);
			$file_name 	= (!empty($name)) ? $name : uniqid().".".$pathinfo['extension'];
			$file_path 	= $dir_name.$file_name;
			if(move_uploaded_file($tmpname, $file_path))
				$return = $file_name;			
		}
		return $return;
	}
}