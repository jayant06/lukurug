<?php

/**
 * This is the model class for table "{{countries}}".
 *
 * The followings are the available columns in table '{{countries}}':
 * @property integer $cnt_id
 * @property string $cnt_name
 * @property string $cnt_code_char2
 * @property string $cnt_code_char3
 * @property string $cnt_un_region
 * @property string $cnt_un_subregion
 */
class Countries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{countries}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cnt_id, cnt_code_char2, cnt_code_char3', 'required'),
			array('cnt_id', 'numerical', 'integerOnly'=>true),
			array('cnt_name', 'length', 'max'=>100),
			array('cnt_code_char2', 'length', 'max'=>2),
			array('cnt_code_char3', 'length', 'max'=>3),
			array('cnt_un_region, cnt_un_subregion', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cnt_id, cnt_name, cnt_code_char2, cnt_code_char3, cnt_un_region, cnt_un_subregion', 'safe', 'on'=>'search'),
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
			'userAddCountry'=>array(self::HAS_MANY, 'UserAddress','uad_country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cnt_id' => 'Cnt',
			'cnt_name' => 'Cnt Name',
			'cnt_code_char2' => 'Cnt Code Char2',
			'cnt_code_char3' => 'Cnt Code Char3',
			'cnt_un_region' => 'Cnt Un Region',
			'cnt_un_subregion' => 'Cnt Un Subregion',
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

		$criteria->compare('cnt_id',$this->cnt_id);
		$criteria->compare('cnt_name',$this->cnt_name,true);
		$criteria->compare('cnt_code_char2',$this->cnt_code_char2,true);
		$criteria->compare('cnt_code_char3',$this->cnt_code_char3,true);
		$criteria->compare('cnt_un_region',$this->cnt_un_region,true);
		$criteria->compare('cnt_un_subregion',$this->cnt_un_subregion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Countries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
