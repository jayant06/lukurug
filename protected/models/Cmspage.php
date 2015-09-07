<?php

/**
 * This is the model class for table "{{cmspage}}".
 *
 * The followings are the available columns in table '{{cmspage}}':
 * @property integer $c_id
 * @property string $c_pagename
 * @property string $c_title
 * @property string $c_subtitle
 * @property string $c_content
 * @property string $c_app_content
 * @property string $c_meta_title
 * @property string $c_meta_keyword
 * @property string $c_meta_description
 * @property integer $c_status
 * @property string $c_created
 * @property string $c_modified
 */
class Cmspage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cmspage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_pagename, c_title, c_content,  c_meta_title, c_meta_keyword, c_meta_description, c_created, c_modified', 'required'),
			array('c_status', 'numerical', 'integerOnly'=>true),
			array('c_pagename', 'length', 'max'=>100),
			array('c_title, c_subtitle, c_meta_title', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('c_id, c_pagename, c_title, c_subtitle, c_content,  c_meta_title, c_meta_keyword, c_meta_description, c_status, c_created, c_modified', 'safe', 'on'=>'search'),
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
			'c_id' => 'Id',
			'c_pagename' => 'Page Name',
			'c_title' => 'Title',
			'c_subtitle' => 'Subtitle',
			'c_content' => 'Content',			
			'c_meta_title' => 'Meta Title',
			'c_meta_keyword' => 'Meta Keyword',
			'c_meta_description' => 'Meta Description',
			'c_status' => 'Status',
			'c_created' => 'Created',
			'c_modified' => 'Last Modified',
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

		$criteria->compare('c_id',$this->c_id);
		$criteria->compare('c_pagename',$this->c_pagename,true);
		$criteria->compare('c_title',$this->c_title,true);
		$criteria->compare('c_subtitle',$this->c_subtitle,true);
		$criteria->compare('c_content',$this->c_content,true);		
		$criteria->compare('c_meta_title',$this->c_meta_title,true);
		$criteria->compare('c_meta_keyword',$this->c_meta_keyword,true);
		$criteria->compare('c_meta_description',$this->c_meta_description,true);
		$criteria->compare('c_status',$this->c_status);
		$criteria->compare('c_created',$this->c_created,true);
		$criteria->compare('c_modified',$this->c_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'pagination'=>array(
				'pageSize'=>1
			)*/
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cmspage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{	
		$this->c_modified = new CDbExpression('NOW()');
		return parent::beforeSave();
	}

	protected function afterFind()
	{
	   
	    $this->c_created = date('Y-m-d H:i:s',(strtotime($this->c_created)-Yii::app()->session['TimeOffSet']));
	    $this->c_modified = date('Y-m-d H:i:s',(strtotime($this->c_modified)-Yii::app()->session['TimeOffSet']));
	   
	    return (parent::afterFind());
	}
}
