<?php

/**
 * This is the model class for table "{{subcategories}}".
 *
 * The followings are the available columns in table '{{subcategories}}':
 * @property integer $sub_id
 * @property integer $sub_cat_id
 * @property string $sub_cat_name
 * @property string $sub_cat_description
 * @property string $sub_cat_title
 * @property string $sub_cat_keyword
 * @property string $sub_meta_description
 */
class Subcategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{subcategories}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sub_cat_id, sub_cat_name', 'required'),
			array('sub_cat_id', 'numerical', 'integerOnly'=>true),
			array('sub_cat_name', 'length', 'max'=>200),
			array('sub_cat_description, sub_cat_title, sub_cat_keyword, sub_meta_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sub_id, sub_cat_id, sub_cat_name, sub_cat_description, sub_cat_title, sub_cat_keyword, sub_meta_description', 'safe', 'on'=>'search'),
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
			'catSubcats'=>array(self::BELONGS_TO, 'Categories','sub_cat_id'),
			'subcatItems'=>array(self::HAS_MANY, 'Items','itm_subcategory_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sub_cat_id' => 'Category Name',
			'sub_cat_name' => 'Subcategory Name',
			'sub_cat_description' => 'Subcategory Description',
			'sub_cat_title' => 'Subcategory Meta Title',
			'sub_cat_keyword' => 'Subcategory Meta Keyword',
			'sub_meta_description' => 'Sub Category Meta Description',
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

		$criteria->compare('sub_id',$this->sub_id);
		$criteria->compare('sub_cat_id',$this->sub_cat_id);
		$criteria->compare('sub_cat_name',$this->sub_cat_name,true);
		$criteria->compare('sub_cat_description',$this->sub_cat_description,true);
		$criteria->compare('sub_cat_title',$this->sub_cat_title,true);
		$criteria->compare('sub_cat_keyword',$this->sub_cat_keyword,true);
		$criteria->compare('sub_meta_description',$this->sub_meta_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subcategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
