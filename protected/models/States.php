<?php

/**
 * This is the model class for table "{{states}}".
 *
 * The followings are the available columns in table '{{states}}':
 * @property integer $st_id
 * @property integer $st_cnt_id
 * @property string $st_cnt_code_char2
 * @property string $st_cnt_code_char3
 * @property string $st_name
 * @property string $st_alternate_name
 * @property string $st_primary_level_name
 * @property string $st_code
 */
class States extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{states}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('st_id, st_cnt_id, st_cnt_code_char2, st_cnt_code_char3, st_code', 'required'),
			array('st_id, st_cnt_id', 'numerical', 'integerOnly'=>true),
			array('st_cnt_code_char2', 'length', 'max'=>2),
			array('st_cnt_code_char3', 'length', 'max'=>3),
			array('st_name, st_primary_level_name', 'length', 'max'=>80),
			array('st_alternate_name', 'length', 'max'=>200),
			array('st_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('st_id, st_cnt_id, st_cnt_code_char2, st_cnt_code_char3, st_name, st_alternate_name, st_primary_level_name, st_code', 'safe', 'on'=>'search'),
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
			'userAddState'=>array(self::HAS_MANY, 'UserAddress','uad_state_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'st_cnt_id' => 'Country',
			'st_name' => 'State Name',
			'st_code' => 'State Code',
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
		$criteria->order = 'st_name ASC';
		$criteria->compare('st_id',$this->st_id);
		$criteria->compare('st_cnt_id',$this->st_cnt_id);
		$criteria->compare('st_cnt_code_char2',$this->st_cnt_code_char2,true);
		$criteria->compare('st_cnt_code_char3',$this->st_cnt_code_char3,true);
		$criteria->compare('st_name',$this->st_name,true);
		$criteria->compare('st_alternate_name',$this->st_alternate_name,true);
		$criteria->compare('st_primary_level_name',$this->st_primary_level_name,true);
		$criteria->compare('st_code',$this->st_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return States the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
