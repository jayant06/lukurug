<?php

/**
 * This is the model class for table "{{fabric_buttons}}".
 *
 * The followings are the available columns in table '{{fabric_buttons}}':
 * @property integer $fbt_id
 * @property integer $fbt_fabric_id
 * @property integer $fbt_button_id
 */
class FabricButtons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fabric_buttons}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fbt_fabric_id, fbt_button_id', 'required'),
			array('fbt_fabric_id, fbt_button_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fbt_id, fbt_fabric_id, fbt_button_id', 'safe', 'on'=>'search'),
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
			'fabButtons'=>array(self::BELONGS_TO, 'Fabrics','fbt_fabric_id'),
			'buttonsFab'=>array(self::BELONGS_TO, 'Buttons','fbt_button_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fbt_id' => 'Fbt',
			'fbt_fabric_id' => 'Fbt Fabric',
			'fbt_button_id' => 'Fbt Button',
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

		$criteria->compare('fbt_id',$this->fbt_id);
		$criteria->compare('fbt_fabric_id',$this->fbt_fabric_id);
		$criteria->compare('fbt_button_id',$this->fbt_button_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FabricButtons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
