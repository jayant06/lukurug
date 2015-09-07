<?php
/**
 * This is the model class for table "{{seo_pages}}".
 *
 * The followings are the available columns in table '{{seo_pages}}':
 * @property integer $sep_id
 * @property string $sep_page_name
 * @property string $sep_page_title
 * @property string $sep_page_keyword
 * @property string $sep_page_meta_desc
 */
class SeoPages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seo_pages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sep_page_name, sep_page_title, sep_page_keyword, sep_page_meta_desc', 'required'),
			array('sep_page_name', 'length', 'max'=>255),
			array('sep_page_title, sep_page_keyword, sep_page_meta_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sep_id, sep_page_name, sep_page_title, sep_page_keyword, sep_page_meta_desc', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sep_page_name' => 'Page Name',
			'sep_page_title' => 'Page Title',
			'sep_page_keyword' => 'Page Keyword',
			'sep_page_meta_desc' => 'Page Meta Description',
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

		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('sep_page_name',$this->sep_page_name,true);
		$criteria->compare('sep_page_title',$this->sep_page_title,true);
		$criteria->compare('sep_page_keyword',$this->sep_page_keyword,true);
		$criteria->compare('sep_page_meta_desc',$this->sep_page_meta_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeoPages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
