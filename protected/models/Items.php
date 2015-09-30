<?php

/**
 * This is the model class for table "{{items}}".
 *
 * The followings are the available columns in table '{{items}}':
 * @property integer $itm_id
 * @property string $itm_name
 * @property integer $itm_subcategory_id
 * @property integer $itm_fabric_id
 * @property double $itm_price
 * @property string $itm_size
 * @property integer $itm_qty
 * @property string $itm_photo
 * @property string $itm_details
 * @property string $itm_meta_title
 * @property string $itm_meta_keyword
 * @property string $itm_meta_description
 * @property string $itm_created
 * @property string $itm_modified
 */
class Items extends CActiveRecord
{
	public $searchCriteria;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{items}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itm_name, itm_subcategory_id, itm_price, itm_size, itm_qty', 'required'),
			array('itm_subcategory_id, itm_fabric_id, itm_qty', 'numerical', 'integerOnly'=>true),
			array('itm_price', 'numerical'),
			array('itm_name, itm_meta_title', 'length', 'max'=>255),
			array('itm_size, itm_photo', 'length', 'max'=>200),
			array('itm_details, itm_meta_title, itm_meta_keyword, itm_meta_description, itm_created, itm_modified, itm_slug, itm_photo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('itm_id, itm_name, itm_subcategory_id, itm_fabric_id, itm_price, itm_size, itm_qty, itm_photo, itm_details, itm_meta_title, itm_meta_keyword, itm_meta_description, itm_created, itm_modified, itm_slug', 'safe', 'on'=>'search'),
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
			'subcatItems'=>array(self::BELONGS_TO, 'Subcategories','itm_subcategory_id'),
			'fabItems'=>array(self::BELONGS_TO, 'Fabrics','itm_fabric_id'),
			'cartItem'=>array(self::HAS_MANY, 'CartItems','citm_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itm_name' => 'Name',
			'itm_subcategory_id' => 'Subcategory',
			'itm_fabric_id' => 'Fabric',
			'itm_price' => 'Price',
			'itm_size' => 'Size',
			'itm_qty' => 'Item in Stock',
			'itm_photo' => 'Photo',
			'itm_details' => 'Details',
			'itm_meta_title' => 'Meta Title',
			'itm_meta_keyword' => 'Meta Keyword',
			'itm_meta_description' => 'Meta Description',			
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
		if(!empty($this->searchCriteria['catid'])){
			$criteria->compare('itm_subcategory_id',$this->searchCriteria['catid']);	
		}
		$criteria->compare('itm_name',$this->itm_name,true);
		$criteria->compare('itm_price',$this->itm_price);
		$criteria->compare('itm_size',$this->itm_size,true);
		$criteria->compare('itm_qty',$this->itm_qty);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Items the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'itm_created',
				'updateAttribute' => 'itm_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}

	/*
	* Change password before saving
	*/
	
	protected function beforeSave()
	{
		if ($this->isNewRecord){
			$slugname = strtolower($this->itm_name);
			$slugname = str_replace(' ', '_', $slugname);
			$slugname = str_replace('-', '_', $slugname);
			$slugname = str_replace('&', '_', $slugname);
			$this->itm_slug = $slugname;			
		}
		return parent::beforeSave();
	}
}
