<?php

/**
 * This is the model class for table "{{categories}}".
 *
 * The followings are the available columns in table '{{categories}}':
 * @property integer $cat_id
 * @property string $cat_name
 * @property string $cat_description
 * @property string $cat_meta_title
 * @property string $cat_meta_keyword
 * @property string $cat_meta_description
 */
class Categories extends CActiveRecord
{
	public $categoryType;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{categories}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_name', 'required'),
			array('cat_name', 'length', 'max'=>255),
			array('cat_description, cat_meta_title, cat_meta_keyword, cat_meta_description, cat_parent_id, cat_parent_type, cat_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cat_id, cat_name, cat_description, cat_meta_title, cat_meta_keyword, cat_meta_description', 'safe', 'on'=>'search'),
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
			'catExams'=>array(self::HAS_MANY, 'Exams','ex_category_id'),
			'uCourcesCategory'=>array(self::HAS_MANY, 'UserCourses','cr_category_id'),
			'courseParent'=>array(self::BELONGS_TO, 'Categories','cat_parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_name' => 'Course Name',
			'cat_description' => 'Course Description',
			'cat_meta_title' => 'Course Meta Title',
			'cat_meta_keyword' => 'Course Meta Keyword',
			'cat_meta_description' => 'Course Meta Description',
			'cat_code' => 'Course Code',
			'cat_parent_id' => 'Parent Course'
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

		$conditions = '';
		if(!empty($this->categoryType)){
			if($this->categoryType==1) //for parent
				$conditions = 'cat_parent_id=0';
			else if($this->categoryType==2) //for sub
				$conditions = 'cat_parent_id!=0 AND cat_parent_type=2';
			else //for childs
				$conditions = 'cat_parent_id!=0 AND cat_parent_type=0';
		}
		if(!empty($conditions))
			$criteria->condition = $conditions;

		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('cat_description',$this->cat_description,true);
		$criteria->compare('cat_meta_title',$this->cat_meta_title,true);
		$criteria->compare('cat_meta_keyword',$this->cat_meta_keyword,true);
		$criteria->compare('cat_meta_description',$this->cat_meta_description,true);
		$criteria->compare('cat_code',$this->cat_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	function generateCatCode()
	{
	    $cCode = 1;
	    $codeAlphabet = "C00";
	    $criteria=new CDbCriteria;
	    $criteria->order = 'cat_code desc';
	    $criteria->limit = 1;
	    $catCodeData = Categories::model()->find($criteria);
	    if(!empty($catCodeData)){
	    	$catcode = str_replace('C00','',$catCodeData->cat_code);
	    	if(!empty($catcode))
	    		$cCode = ($catcode+1);
	    }
	    return $codeAlphabet.$cCode;
	}	
}
