<?php

/**
 * This is the model class for table "{{email_manager}}".
 *
 * The followings are the available columns in table '{{email_manager}}':
 * @property integer $em_id
 * @property string $em_title
 * @property string $em_email_subject
 * @property string $em_email_template
 * @property string $em_created
 * @property string $em_modified
 */
class EmailManager extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{email_manager}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('em_title', 'length', 'max'=>50),
			array('em_title, em_email_subject, em_email_template', 'required'),
			array('em_email_template, em_created, em_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('em_id, em_title, em_email_subject, em_email_template, em_created, em_modified', 'safe', 'on'=>'search'),
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
			'em_id' => 'Em',
			'em_title' => 'Title',
			'em_email_subject' => 'Email Subject',
			'em_email_template' => 'Email Template',
			'em_created' => 'Created',
			'em_modified' => 'Last Modified',
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

		$criteria->compare('em_id',$this->em_id);
		$criteria->compare('em_title',$this->em_title,true);
		$criteria->compare('em_email_subject',$this->em_email_subject,true);
		$criteria->compare('em_email_template',$this->em_email_template,true);
		$criteria->compare('em_created',$this->em_created,true);
		$criteria->compare('em_modified',$this->em_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailManager the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{	
		$this->em_modified = new CDbExpression('NOW()');
		return parent::beforeSave();
	}

	protected function afterFind()
	{
	   
	    $this->em_created = date('Y-m-d H:i:s',(strtotime($this->em_created)-Yii::app()->session['TimeOffSet']));
	    $this->em_modified = date('Y-m-d H:i:s',(strtotime($this->em_modified)-Yii::app()->session['TimeOffSet']));
	   
	    return (parent::afterFind());
	}
}
