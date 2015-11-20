<?php

/**
 * This is the model class for table "{{questions_options}}".
 *
 * The followings are the available columns in table '{{questions_options}}':
 * @property integer $qto_id
 * @property string $qto_name
 * @property string $qto_image
 */
class QuestionsOptions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{questions_options}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qto_name, qto_question_id, qto_right_ans', 'required'),
			array('qto_name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('qto_id, qto_name, qto_image, qto_question_id, qto_right_ans', 'safe'),
			array('qto_id, qto_name, qto_image, qto_question_id, qto_right_ans', 'safe', 'on'=>'search'),
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
			'qoptQat'=>array(self::BELONGS_TO, 'Questions','qto_question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'qto_name' => 'Option',
			'qto_image' => 'Option Image',
			'qto_question_id' => 'Question'
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

		$criteria->compare('qto_id',$this->qto_id);
		$criteria->compare('qto_name',$this->qto_name,true);
		$criteria->compare('qto_question_id',$this->qto_question_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuestionsOptions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
