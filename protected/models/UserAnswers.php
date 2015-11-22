<?php

/**
 * This is the model class for table "{{user_answers}}".
 *
 * The followings are the available columns in table '{{user_answers}}':
 * @property integer $ua_id
 * @property integer $ua_user_id
 * @property integer $ua_exam_id
 * @property integer $ua_question_id
 * @property integer $ua_option_id
 * @property string $ua_created
 * @property string $ua_modified
 */
class UserAnswers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_answers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ua_user_id, ua_question_id, ua_option_id', 'required'),
			array('ua_user_id, ua_question_id, ua_option_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ua_id, ua_user_id, ua_question_id, ua_option_id, ua_created, ua_modified', 'safe', 'on'=>'search'),
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
			'uaUser'=>array(self::BELONGS_TO, 'User','ua_user_id'),
			'uaQuestion'=>array(self::BELONGS_TO, 'Questions','ua_question_id'),
			'uaQoptions'=>array(self::BELONGS_TO, 'QuestionsOptions','ua_option_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ua_id' => 'Ua',
			'ua_user_id' => 'Ua User',
			'ua_question_id' => 'Ua Question',
			'ua_option_id' => 'Ua Option',
			'ua_created' => 'Ua Created',
			'ua_modified' => 'Ua Modified',
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

		$criteria->compare('ua_id',$this->ua_id);
		$criteria->compare('ua_user_id',$this->ua_user_id);
		$criteria->compare('ua_question_id',$this->ua_question_id);
		$criteria->compare('ua_option_id',$this->ua_option_id);
		$criteria->compare('ua_created',$this->ua_created,true);
		$criteria->compare('ua_modified',$this->ua_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAnswers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'ua_created',
				'updateAttribute' => 'ua_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}

	public function getAnswersQuestionWise($examId){
		$user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;
		$criteria->condition = "qt_exam_id=:qt_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':qt_exam_id' => $examId,':ua_user_id' => $user_id);
		$model = UserAnswers::model()->with(array('uaQuestion'))->findAll($criteria);

		$criteriaQ=new CDbCriteria;
		$criteriaQ->condition = "qt_exam_id=:qt_exam_id AND qto_right_ans=:qto_right_ans";
		$criteriaQ->params = array(':qt_exam_id' => $examId,':qto_right_ans' => 1);
		$opModel = QuestionsOptions::model()->with(array('qoptQat'))->findAll($criteriaQ);

		$answers = array();
		if(!empty($opModel)){
			foreach ($opModel as $opKey => $opArr) {
				$answers[$opArr->qto_question_id]['rightoption'] = $opArr->qto_id;				
			}
		}
		
		if(!empty($model)){
			foreach ($model as $uKey => $uArr) {
				$answers[$uArr->ua_question_id]['option'] = $uArr->ua_option_id;				
			}
		}

		return $answers;		
	}

	public function getTotalScore($examId){
		$user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;
		$criteria->condition = "qt_exam_id=:qt_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':qt_exam_id' => $examId,':ua_user_id' => $user_id);
		$model = UserAnswers::model()->with(array('uaQuestion','uaQoptions'))->findAll($criteria);
		$totalScore = 0;
		if(!empty($model)){
			foreach ($model as $uaKey => $uaArr) {
				$qoId = $uaArr->ua_option_id;
				if($uaArr->uaQoptions->qto_right_ans==1){
					$totalScore += $uaArr->uaQuestion->qt_marks;
				}
			}
		}

		return $totalScore;		
	}
}
