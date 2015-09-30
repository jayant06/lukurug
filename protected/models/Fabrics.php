<?php

/**
 * This is the model class for table "{{fabrics}}".
 *
 * The followings are the available columns in table '{{fabrics}}':
 * @property integer $fab_id
 * @property string $fab_name
 * @property string $fab_image
 */
class Fabrics extends CActiveRecord
{
	public $fab_imagecust_option,$fab_imagecust_suboption,$searchCriteria;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fabrics}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fab_name,fab_color, fab_fabric', 'required'),
			array('fab_name, fab_image', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fab_price,fab_pattern,fab_for', 'safe'),
			array('fab_id, fab_name, fab_image', 'safe', 'on'=>'search'),
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
			'fabItems'=>array(self::HAS_MANY, 'Items','itm_fabric_id'),
			'fabButtons'=>array(self::HAS_MANY, 'FabricButtons','fbt_fabric_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fab_name' => 'Fabric Name',
			'fab_image' => 'Fabric Image',
			'fab_price' => 'Fabric Price',
			'fab_color' => 'Fabric Color',
			'fab_pattern' => 'Fabric Pattern',
			'fab_for' => 'Fabric for',
			'fab_fabric' => 'Fabric'
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

		$criteria->compare('fab_id',$this->fab_id);
		$criteria->compare('fab_name',$this->fab_name,true);
		if(isset($this->searchCriteria['fab_for']))
			$criteria->compare('fab_for',$this->searchCriteria['fab_for']);
		if(isset($this->searchCriteria['fab_color']))
			$criteria->compare('fab_color',$this->searchCriteria['fab_color']);
		if(isset($this->searchCriteria['fab_pattern']))
			$criteria->compare('fab_pattern',$this->searchCriteria['fab_pattern']);
		if(isset($this->searchCriteria['fab_fabric']))
			$criteria->compare('fab_fabric',$this->searchCriteria['fab_fabric']);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Fabrics the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
