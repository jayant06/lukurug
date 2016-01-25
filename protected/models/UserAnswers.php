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
			array('ua_user_id, ua_question_id, ua_option_id, ua_exam_id', 'required'),
			array('ua_user_id, ua_question_id, ua_option_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ua_id, ua_user_id, ua_question_id, ua_option_id, ua_created, ua_modified, ua_exam_id', 'safe', 'on'=>'search'),
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
		$criteria->condition = "ua_exam_id=:ua_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':ua_exam_id' => $examId,':ua_user_id' => $user_id);
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
		$criteria->condition = "ua_exam_id=:ua_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':ua_exam_id' => $examId,':ua_user_id' => $user_id);
		$model = UserAnswers::model()->with(array('uaQuestion','uaQoptions'))->findAll($criteria);
		$totalScore = 0;

		if(!empty($model)){
			foreach ($model as $uaKey => $uaArr) {
				$qoId = $uaArr->ua_option_id;
				if(@$uaArr->uaQoptions->qto_right_ans==1){
					$totalScore += $uaArr->uaQuestion->qt_marks;
				}
			}
		}

		return $totalScore;		
	}

	public function getCountRightAns($examId){
		$user_id = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->condition = "ua_exam_id=:ua_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':ua_exam_id' => $examId,':ua_user_id' => $user_id);
		$model = UserAnswers::model()->with(array('uaQuestion','uaQoptions'))->findAll($criteria);
		$totalScore = 0;		
		if(!empty($model)){
			foreach ($model as $uaKey => $uaArr) {
				$qoId = $uaArr->ua_option_id;
				if(@$uaArr->uaQoptions->qto_right_ans==1){
					$totalScore += 1;
				}
			}
		}

		return $totalScore;		
	}

	public function getUserQuestions($user_id=0,$ua_user_exam_id=0){
		$result = Yii::app()->db->createCommand()
				    ->select('ua.*,ex.*, qt.qt_id, qt.qt_name,qt.qt_description,qt.qt_type,qt.qt_image,qto_id,qto_name,qto_image,qto_right_ans')
				    ->from('{{user_answers}} ua')
				    ->join('{{exams}} ex', 'ex.ex_id = ua.ua_exam_id')
				    ->join('{{questions}} qt', 'qt.qt_id = ua.ua_question_id')
				    ->join('{{questions_options}} qto', 'qto.qto_question_id = qt.qt_id')
				    ->where('ua_user_id=:ua_user_id AND ua_user_exam_id=:ua_user_exam_id' , array(':ua_user_id' =>$user_id, ':ua_user_exam_id' =>$ua_user_exam_id))
				    // ->andWhere('i.item_id = :value2' , array('value2' => $value2))
				    ->order('ua.ua_id')
				    ->queryAll(); // this will be returned as an array of arrays
				    // ->query();
		return $result;
		/*$criteria = new CDbCriteria;
		$criteria->select = 't.*, Q.qt_id, Q.qt_name,Q.qt_description,Q.qt_type,Q.qt_image';
		$criteria->join = "INNER JOIN {{questions}} AS Q ON Q.qt_id = t.ua_question_id";
		$criteria->condition = "ua_user_id=:ua_user_id AND ua_user_exam_id=:ua_user_exam_id";
		$criteria->params = array(':ua_user_id' =>$user_id, ':ua_user_exam_id' =>$ua_user_exam_id);
		return $this->findAll($criteria);*/
	}

	public function getUserQuestionsStatistics($user_id=0,$ua_user_exam_id=0){
		$result = Yii::app()->db->createCommand()
				    ->select('COUNT(ua.ua_id) total_question,SUM(IF(ua.ua_answer_status=2,1,0)) total_attempted,SUM(IF(ua.ua_answer_status=1,1,0)) total_not_attempted,SUM(IF(ua.ua_answer_status=0,1,0)) total_not_viewed,SUM(IF(ua.ua_answer_status=3,1,0)) total_submitted,SUM(IF(ua.ua_answer=1,1,0)) total_correct,SUM(IF(ua.ua_answer=0,1,0)) total_wrong,ex.ex_title,ex.ex_start_date_time,ex.ex_end_date_time,ex.ex_duration')
				    ->from('{{user_answers}} ua')
				    ->join('{{exams}} ex', 'ex.ex_id = ua.ua_exam_id')
				    ->where('ua_user_id=:ua_user_id AND ua_user_exam_id=:ua_user_exam_id' , array(':ua_user_id' =>$user_id, ':ua_user_exam_id' =>$ua_user_exam_id))
				    ->group('ua.ua_user_exam_id')
				    ->queryRow(); // this will be returned as an array of arrays
				    // ->query();
		return $result;
	}

	public function getUserAnswersQuestion($user_id=0,$ua_user_exam_id=0){
		$criteria = new CDbCriteria;
		$criteria->condition = "ua_user_id=:ua_user_id AND ua_user_exam_id=:ua_user_exam_id";
		$criteria->params = array(':ua_user_id' =>$user_id, ':ua_user_exam_id' =>$ua_user_exam_id);
		return $this->findAll($criteria);
	}

	public function generateUserAnswersQuestion($user_id=0,$exam_id=0,$ua_user_exam_id=0){
		$criteria = new CDbCriteria;
		$criteria->condition = "qt_exam_id=:qt_exam_id";
		$criteria->order = "rand()";
		$criteria->params = array(':qt_exam_id' => $exam_id);
		$questions = Questions::model()->findAll($criteria);

		foreach ($questions as $key => $value) {
			# code...
			$this->ua_id = NULL;
			$this->isNewRecord = true;
			$this->ua_user_id = $user_id;
			$this->ua_exam_id = $exam_id;
			$this->ua_user_exam_id = $ua_user_exam_id;
			$this->ua_question_id = $value->qt_id;
			$this->insert();
			// print_r($value->qt_id); 
			// exit;
		}
		$criteria = new CDbCriteria;
		$criteria->condition = "ua_exam_id=:ua_exam_id AND ua_user_id=:ua_user_id";
		$criteria->params = array(':ua_exam_id' => $exam_id, ':ua_user_id' =>$user_id);
		return $this->findAll($criteria);
		// print_r($questions);
		// print_r($model); exit;
	}
}
