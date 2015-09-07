<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_USERNAME_NOT_ACTIVE  = 3;
	const ERROR_EMAIL_NOT_VERIFIED  = 4;	

	private $_id;	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public $_role; 
	 
	public function authenticate()
	{
		$user=User::model()->find('LOWER(u_email)=:email',array(':email'=>strtolower($this->username)));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password)){			
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}elseif($user->u_status == 0){
			$this->errorCode=self::ERROR_USERNAME_NOT_ACTIVE;
		}elseif($user->u_mail_verify == 0){
			$this->errorCode=self::ERROR_EMAIL_NOT_VERIFIED;
		}else{
			$user->u_last_login_date = new CDbExpression('NOW()');
			$user->save(false);							            
			$this->_id=$user->u_id;
			$this->username=$user->u_email;
			$this->_role=$user->u_role;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
	
	public function getRole()
	{
		return $this->_role;
	}

}