<?php

/**
 * This is the model class for table "{{cart}}".
 *
 * The followings are the available columns in table '{{cart}}':
 * @property integer $cart_id
 * @property integer $cart_user_id
 * @property string $cart_created
 * @property string $cart_modified
 */
class Cart extends CActiveRecord
{
	public $u_email;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cart_user_id,cart_orderno', 'required'),
			array('cart_user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cart_payment_status, cart_order_status, cart_paypal_result', 'safe'),
			array('cart_id, cart_user_id, cart_created, cart_modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cartCartItem'=>array(self::HAS_MANY, 'CartItems','citm_cart_id'),
			'userCart'=>array(self::BELONGS_TO, 'User','cart_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cart_orderno' => 'Order No',
			'cart_user_id' => 'Username',
			'cart_created' => 'Order Date'	,
			'cart_order_status' => 'Order Status',
			'u_email' => 'Customer email'		
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		if(empty($this->cart_user_id)){
			$criteria->condition = "cart_payment_status=:cart_payment_status";
			$criteria->params = array(':cart_payment_status' => 2);
		}
		$criteria->with = array('userCart'=>array('select' => array('u_email')));
		$criteria->order = 'cart_id DESC';
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('cart_user_id',$this->cart_user_id);
		$criteria->compare('cart_created',$this->cart_created,true);
		$data = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));
		return $data; 
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'cart_created',
				'updateAttribute' => 'cart_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
