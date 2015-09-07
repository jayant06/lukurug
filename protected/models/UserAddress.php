<?php

/**
 * This is the model class for table "{{user_address}}".
 *
 * The followings are the available columns in table '{{user_address}}':
 * @property integer $uad_id
 * @property integer $uad_user_id
 * @property string $uad_add1
 * @property string $uad_add2
 * @property integer $uad_country_id
 * @property integer $uad_state_id
 * @property integer $uad_city
 * @property string $uad_zipcode
 * @property string $uad_mobile
 * @property integer $uad_type
 * @property string $uad_created
 * @property string $uad_modified
 */
class UserAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uad_user_id, uad_add1, uad_country_id, uad_state_id, uad_city, uad_zipcode, uad_mobile', 'required'),
			array('uad_user_id, uad_country_id, uad_state_id, uad_city, uad_type', 'numerical', 'integerOnly'=>true),
			array('uad_add1, uad_add2', 'length', 'max'=>255),
			array('uad_zipcode, uad_mobile', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uad_type, uad_created, uad_modified', 'safe'),
			array('uad_id, uad_user_id, uad_add1, uad_add2, uad_country_id, uad_state_id, uad_city, uad_zipcode, uad_mobile, uad_type, uad_created, uad_modified', 'safe', 'on'=>'search'),
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
			'userAdd'=>array(self::BELONGS_TO, 'User','uad_user_id'),
			'userAddCountry'=>array(self::BELONGS_TO, 'Countries','uad_country_id'),
			'userAddState'=>array(self::BELONGS_TO, 'States','uad_state_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uad_add1' => 'Address Line 1',
			'uad_add2' => 'Address Line 2',
			'uad_country_id' => 'Country',
			'uad_state_id' => 'State/Province',
			'uad_city' => 'City',
			'uad_zipcode' => 'Zip',
			'uad_mobile' => 'Mobile',						
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

		$criteria->compare('uad_id',$this->uad_id);
		$criteria->compare('uad_user_id',$this->uad_user_id);
		$criteria->compare('uad_add1',$this->uad_add1,true);
		$criteria->compare('uad_add2',$this->uad_add2,true);
		$criteria->compare('uad_country_id',$this->uad_country_id);
		$criteria->compare('uad_state_id',$this->uad_state_id);
		$criteria->compare('uad_city',$this->uad_city);
		$criteria->compare('uad_zipcode',$this->uad_zipcode,true);
		$criteria->compare('uad_mobile',$this->uad_mobile,true);
		$criteria->compare('uad_type',$this->uad_type);
		$criteria->compare('uad_created',$this->uad_created,true);
		$criteria->compare('uad_modified',$this->uad_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'uad_created',
				'updateAttribute' => 'uad_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
