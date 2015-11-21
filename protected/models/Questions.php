<?php

/**
 * This is the model class for table "{{questions}}".
 *
 * The followings are the available columns in table '{{questions}}':
 * @property integer $qt_id
 * @property integer $qt_exam_id
 * @property string $qt_name
 * @property string $qt_description
 * @property integer $qt_type
 * @property integer $qt_marks
 * @property string $qt_created
 * @property string $qt_modified
 */
class Questions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{questions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qt_exam_id, qt_name, qt_type, qt_marks', 'required'),
			array('qt_exam_id, qt_type, qt_marks', 'numerical', 'integerOnly'=>true),
			array('qt_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('qt_id, qt_exam_id, qt_name, qt_description, qt_type, qt_marks, qt_created, qt_modified', 'safe'),
			array('qt_id, qt_exam_id, qt_name, qt_description, qt_type, qt_marks, qt_created, qt_modified', 'safe', 'on'=>'search'),
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
			'qatExams'=>array(self::BELONGS_TO, 'Exams','qt_exam_id'),
			'qoptQat'=>array(self::HAS_MANY, 'QuestionsOptions','qto_question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'qt_exam_id' => 'Exams',
			'qt_name' => 'Question',
			'qt_description' => 'Description',
			'qt_type' => 'Question Type',
			'qt_marks' => 'Total Marks'
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

		$criteria->compare('qt_exam_id',$this->qt_exam_id);
		$criteria->compare('qt_name',$this->qt_name,true);
		$criteria->compare('qt_description',$this->qt_description,true);
		$criteria->compare('qt_type',$this->qt_type);
		$criteria->compare('qt_marks',$this->qt_marks);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getquestions(){
		$criteria=new CDbCriteria;
		$criteria->order = "qt_name ASC";
		$criteria->condition = "qt_exam_id=:qt_exam_id";
		$criteria->params = array(':qt_exam_id' => $this->qt_exam_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
	            'pageSize' => 1,
	        ),
		));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Questions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'qt_created',
				'updateAttribute' => 'qt_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
