<?php

/**
 * This is the model class for table "{{user_measurements}}".
 *
 * The followings are the available columns in table '{{user_measurements}}':
 * @property integer $umr_id
 * @property string $umr_name
 * @property integer $umr_product_type
 * @property integer $umr_type
 * @property string $umr_size
 * @property integer $umr_fit
 * @property integer $umr_collor
 * @property integer $umr_shirt_length
 * @property integer $umr_long_sleeve
 * @property integer $umr_short_sleeve
 * @property integer $umr_shoulder
 * @property integer $umr_chest_half
 * @property integer $umr_mid_section_half
 * @property integer $umr_hip_half
 * @property integer $umr_short_sleeve_opening
 * @property integer $umr_arm_half
 * @property integer $umr_cuff
 * @property integer $umr_height
 * @property integer $umr_feet
 * @property integer $umr_weight
 * @property integer $umr_describe_arms
 * @property integer $umr_wear_shirt
 * @property integer $umr_prefer_wear
 * @property integer $umr_stomach
 * @property integer $umr_hip
 * @property integer $umr_chest
 * @property string $umr_created
 * @property string $umr_modified
 */
class UserMeasurements extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_measurements}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('umr_name,umr_user_id', 'required'),
			array('umr_name, umr_size, umr_id, umr_product_type, umr_type, umr_fit, umr_collor, umr_shirt_length, umr_long_sleeve, umr_short_sleeve, umr_shoulder, umr_chest_half, umr_mid_section_half, umr_hip_half, umr_short_sleeve_opening, umr_arm_half, umr_cuff, umr_height, umr_feet, umr_weight, umr_describe_arms, umr_wear_shirt, umr_prefer_wear, umr_stomach, umr_hip, umr_chest,umr_collor_measurment,umr_shoulder_structure', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('umr_id, umr_name, umr_product_type, umr_type, umr_size, umr_fit, umr_collor, umr_shirt_length, umr_long_sleeve, umr_short_sleeve, umr_shoulder, umr_chest_half, umr_mid_section_half, umr_hip_half, umr_short_sleeve_opening, umr_arm_half, umr_cuff, umr_height, umr_feet, umr_weight, umr_describe_arms, umr_wear_shirt, umr_prefer_wear, umr_stomach, umr_hip, umr_chest, umr_created, umr_modified', 'safe', 'on'=>'search'),
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
			'userMeasurement'=>array(self::BELONGS_TO, 'User','umr_user_id'),
			'cartUserMeasurement'=>array(self::HAS_MANY, 'CartItems','citm_user_measurement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'umr_name' => 'Profile name',
			'umr_product_type' => '0=Shirt, 1=Trouser, 2=Blazer',
			'umr_type' => '0=Standard size, 1=send a shirt, 2=shirt measurment, 3=body measurment',
			'umr_size' => 'Select Size',
			'umr_fit' => 'Select Fit',
			'umr_collor' => 'Collor',
			'umr_shirt_length' => 'Shirt length',
			'umr_long_sleeve' => 'Long sleeve length(optional)',
			'umr_short_sleeve' => 'Short sleeve length',
			'umr_shoulder' => 'Shoulder',
			'umr_chest_half' => 'Chest(half)',
			'umr_mid_section_half' => 'Mid Section(half)',
			'umr_hip_half' => 'Hip(half)',
			'umr_short_sleeve_opening' => 'Short sleeve opening',
			'umr_arm_half' => 'Arm half',
			'umr_cuff' => 'Cuff(optional)',
			'umr_height' => 'Height',
			'umr_feet' => 'Feet',
			'umr_weight' => 'Weight',
			'umr_describe_arms' => 'Describe Arms',
			'umr_wear_shirt' => 'Wear Shirt',
			'umr_prefer_wear' => '0 = formal short sleeves,1 = casual short sleeves,2 = short sleeves',
			'umr_stomach' => 'Stomach Measurement',
			'umr_hip' => 'Hip Measurement',
			'umr_chest' => 'Chest Measurement',
			'umr_collor_measurment' => 'Collar Measurement (Estimated size: 15 inches)'			
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

		$criteria->compare('umr_id',$this->umr_id);
		$criteria->compare('umr_name',$this->umr_name,true);
		$criteria->compare('umr_product_type',$this->umr_product_type);
		$criteria->compare('umr_type',$this->umr_type);
		$criteria->compare('umr_size',$this->umr_size,true);
		$criteria->compare('umr_fit',$this->umr_fit);
		$criteria->compare('umr_collor',$this->umr_collor);
		$criteria->compare('umr_shirt_length',$this->umr_shirt_length);
		$criteria->compare('umr_long_sleeve',$this->umr_long_sleeve);
		$criteria->compare('umr_short_sleeve',$this->umr_short_sleeve);
		$criteria->compare('umr_shoulder',$this->umr_shoulder);
		$criteria->compare('umr_chest_half',$this->umr_chest_half);
		$criteria->compare('umr_mid_section_half',$this->umr_mid_section_half);
		$criteria->compare('umr_hip_half',$this->umr_hip_half);
		$criteria->compare('umr_short_sleeve_opening',$this->umr_short_sleeve_opening);
		$criteria->compare('umr_arm_half',$this->umr_arm_half);
		$criteria->compare('umr_cuff',$this->umr_cuff);
		$criteria->compare('umr_height',$this->umr_height);
		$criteria->compare('umr_feet',$this->umr_feet);
		$criteria->compare('umr_weight',$this->umr_weight);
		$criteria->compare('umr_describe_arms',$this->umr_describe_arms);
		$criteria->compare('umr_wear_shirt',$this->umr_wear_shirt);
		$criteria->compare('umr_prefer_wear',$this->umr_prefer_wear);
		$criteria->compare('umr_stomach',$this->umr_stomach);
		$criteria->compare('umr_hip',$this->umr_hip);
		$criteria->compare('umr_chest',$this->umr_chest);
		$criteria->compare('umr_created',$this->umr_created,true);
		$criteria->compare('umr_modified',$this->umr_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserMeasurements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'umr_created',
				'updateAttribute' => 'umr_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
