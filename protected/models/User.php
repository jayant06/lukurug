<?php
class User extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $profile
	 */
	public $u_repeat_password;
	public $terms_conditions;
	public $old_password;
	public $new_password;
	public $new_repeat_password;
	public $u_username;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}
	
	public function search() {
		$criteria=new CDbCriteria;		
		
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->addCondition("u_role <> 'admin'",'AND');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,		
			/* 'pagination'=>array(
				'pageSize'=>3
			) */	
		));
	}	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.		
		$rules = array(			
			array('u_first_name, u_last_name, u_email, u_password, u_repeat_password, u_gender', 'required','on'=>'insert,admininsert'),			
			array('u_email', 'length', 'max'=>50,'on'=>'insert,admininsert,useredit,adminprofile'),			
			array('u_password, u_repeat_password', 'required', 'on'=>'resetpass'),
			array('u_password', 'length', 'min'=>6, 'max'=>32,'on'=>'insert,admininsert,resetpass'),
			array('u_repeat_password', 'compare', 'compareAttribute'=>'u_password','on'=>'insert,admininsert,resetpass'),
			array('u_email', 'email'),
			array('u_email', 'unique'),			
			array('terms_conditions','required','on'=>'insert','message'=>'Please agree terms and conditions'),			
			array('u_email, u_gender','required','on'=>'adminprofile'),
			array('u_gender','required','on'=>'useredit'),
			//RESET PASSWORD RULES
			array('old_password, new_password, new_repeat_password','required','on'=>'changepassword'),
			array('old_password','verifyPassword','on'=>'changepassword'),
			array('old_password, new_password, new_repeat_password', 'length', 'min'=>6, 'max'=>32,'on'=>'changepassword'),
			array('new_repeat_password','compare','compareAttribute'=>'new_password','on'=>'changepassword'),
			array('u_email, u_first_name, u_last_name, u_password, u_repeat_password, u_gender, terms_conditions, old_password, new_password, new_repeat_password, u_addmission_date', 'safe'),
		);
		
		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'userAdd'=>array(self::HAS_MANY, 'UserAddress','uad_user_id'),
			'uaUser'=>array(self::HAS_MANY, 'UserAnswers','ua_user_id'),
			'ueUser'=>array(self::HAS_MANY, 'UserExams','ue_user_id'),
			'uCources'=>array(self::HAS_MANY, 'UserCourses','cr_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'u_id' => 'Id',
			'u_first_name' => 'First name',
			'u_last_name' => 'Last name',
			'u_email' => 'Email',			
			'u_password' => 'Password',		
			'u_repeat_password' => 'Confirm Password',			
			'u_gender' => 'Gender',			
			'terms_conditions'=>'I agree',
			//CHANGE PASSWORD	
			'old_password'=>'Old Password',
			'new_password'=>'New Password',
			'new_repeat_password'=>'Repeat New Password',
			'u_status'=>'Status',
			'u_username' => 'Username',
			'u_addmission_date' => 'Admission Date'
		);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->u_password);
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
	
	/*
	* Change password before saving
	*/
	
	protected function beforeSave()
	{
		//hash password on before saving the record: 		
		if ($this->isNewRecord){
			$this->u_role = 'member';
			$this->u_password = $this->hashPassword($this->u_password);		
		}
		if($this->scenario=='resetpass')
			$this->u_password = $this->hashPassword($this->u_password);
		
		if($this->scenario=='changepassword')
			$this->u_password = $this->hashPassword($this->new_password);
		
		$this->u_modified = new CDbExpression('NOW()');

		return parent::beforeSave();
	}
	
	/*
	*assign role in authassignment
	*/
	
	protected function afterSave(){
		if ($this->isNewRecord){
			$auth = Yii::app()->authManager;			
			$auth->assign($this->u_role,$this->u_id);						
		}		
		parent::afterSave();
	}
	
	public function uniqueEmailByRole($attribute,$params) {		
    	if(User::model()->count('u_email=:u_email',array(':u_email'=>$this->u_email)) > 0) {			
			$this->addError( $attribute, 'Email "'.$this->u_email.'" is already exists' );			
    	}
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'u_created',
				'updateAttribute' => 'u_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}

	public function verifyPassword($attribute,$params){
		if(!CPasswordHelper::verifyPassword($this->old_password,$this->u_password)){
			$this->addErrors(array('old_password'=>'Incorrect old password.'));
		}
	}

	protected function afterFind()
	{  
	    $this->u_created = date('Y-m-d H:i:s',(strtotime($this->u_created)-Yii::app()->session['TimeOffSet']));
	    $this->u_modified = date('Y-m-d H:i:s',(strtotime($this->u_modified)-Yii::app()->session['TimeOffSet']));
	    $this->u_last_login_date = date('Y-m-d H:i:s',(strtotime($this->u_last_login_date)-Yii::app()->session['TimeOffSet']));
	    return (parent::afterFind());
	}

	public function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

	   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}

	public function checkStatus(){
		return $this->findByPk(Yii::app()->user->id,array('select'=>'u_status,u_first_name,u_last_name'));
	}

	public function userlist() {
		
		$criteria=new CDbCriteria;		
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('u_first_name',$this->u_first_name,true);
		$criteria->compare('u_last_name',$this->u_last_name,true);
		$criteria->addCondition("u_role <> 'admin'",'AND');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,		
			'sort'=>false
			/* 'pagination'=>array(
				'pageSize'=>3
			) */	
		));
	}

}
