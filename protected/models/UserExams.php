<?php

/**
 * This is the model class for table "{{user_exams}}".
 *
 * The followings are the available columns in table '{{user_exams}}':
 * @property integer $ue_id
 * @property integer $ue_user_id
 * @property integer $ue_exam_id
 * @property string $ue_created
 * @property string $ue_modified
 */
class UserExams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_exams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ue_user_id, ue_exam_id', 'required'),
			array('ue_user_id, ue_exam_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ue_id, ue_user_id, ue_exam_id, ue_created, ue_modified', 'safe', 'on'=>'search'),
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
			'ueExam'=>array(self::BELONGS_TO, 'Exams','ue_exam_id'),
			'ueUser'=>array(self::BELONGS_TO, 'User','ue_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ue_id' => 'Ue',
			'ue_user_id' => 'User',
			'ue_exam_id' => 'Exam',
			'ex_title' => 'Exam Title',
			'ex_details' => 'Exam Details'
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

		$criteria->compare('ue_id',$this->ue_id);
		$criteria->compare('ue_user_id',$this->ue_user_id);
		$criteria->compare('ue_exam_id',$this->ue_exam_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserExams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'ue_created',
				'updateAttribute' => 'ue_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}