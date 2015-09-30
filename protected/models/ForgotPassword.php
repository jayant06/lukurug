<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ForgotPassword extends CFormModel
{
	public $username;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username', 'required'),
			// rememberMe needs to be a boolean
			array('username', 'email'),
			//safe
			array('username', 'checkEmail'),			

			array('username', 'safe')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Email',			
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function checkEmail($attribute,$params)
	{
		if($this->scenario=='adminpass'){
			$user=User::model()->find('LOWER(u_email)=:email AND u_role = "admin"',array(':email'=>strtolower($this->username)));
		}else{
			$user=User::model()->find('LOWER(u_email)=:email',array(':email'=>strtolower($this->username)));
		}
		if($user===null){				
			if($this->scenario=='adminpass'){
				$this->addError('username','The email you have entered is invalid.');		
			}else{	
				$this->addError('username','The email you have entered does not exists.');
			}
		}
		elseif($this->scenario!='adminpass' && $user->u_mail_verify==0)
			$this->addError('username','The email you have entered is not verified.');
	}	
}
