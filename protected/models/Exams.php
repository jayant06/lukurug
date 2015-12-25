<?php

/**
 * This is the model class for table "{{exams}}".
 *
 * The followings are the available columns in table '{{exams}}':
 * @property integer $ex_id
 * @property integer $ex_category_id
 * @property string $ex_title
 * @property string $ex_details
 * @property string $ex_start_date_time
 * @property string $ex_end_date_time
 * @property string $ex_created
 * @property string $ex_modified
 */
class Exams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ex_category_id, ex_title, ex_start_date_time, ex_end_date_time', 'required'),
			array('ex_category_id', 'numerical', 'integerOnly'=>true),
			array('ex_title', 'length', 'max'=>200),
			array('ex_details', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ex_id, ex_category_id, ex_title, ex_details, ex_start_date_time, ex_end_date_time, ex_created, ex_modified', 'safe', 'on'=>'search'),
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
			'catExams'=>array(self::BELONGS_TO, 'Categories','ex_category_id'),
			'qatExams'=>array(self::HAS_MANY, 'Questions','qt_exam_id'),
			'uaExam'=>array(self::HAS_MANY, 'UserAnswers','ua_exam_id'),
			'ueExam'=>array(self::HAS_MANY, 'UserExams','ue_exam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ex_category_id' => 'Course',
			'ex_title' => 'Title',
			'ex_details' => 'Details',
			'ex_start_date_time' => 'Start Date Time',
			'ex_end_date_time' => 'End Date Time',			
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

		$criteria->compare('ex_category_id',$this->ex_category_id);
		$criteria->compare('ex_title',$this->ex_title,true);
		$criteria->compare('ex_start_date_time',$this->ex_start_date_time,true);
		$criteria->compare('ex_end_date_time',$this->ex_end_date_time,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getexams(){
		$user_id = Yii::app()->user->id;
		$criteria1=new CDbCriteria;
		$criteria1->condition = 'ue_user_id=:ue_user_id';
		$criteria1->params = array(':ue_user_id'=> $user_id);
		$userExams = UserExams::model()->findAll($criteria1);
		$uExams = array();
		if(!empty($userExams)){
			foreach ($userExams as $uakey => $uaArr) {
				$uExams[] = $uaArr->ue_exam_id;
			}
		}
		
		$criteria=new CDbCriteria;
		$criteria->order = "ex_title ASC";
		$cond = 'NOW() between ex_start_date_time and ex_end_date_time';
		if(!empty($uExams)){
			$cond .= " and ex_id not in(".implode(', ',$uExams).")";
		}

		$criteria->condition = $cond;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Exams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'ex_created',
				'updateAttribute' => 'ex_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
