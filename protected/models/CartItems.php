<?php

/**
 * This is the model class for table "{{cart_items}}".
 *
 * The followings are the available columns in table '{{cart_items}}':
 * @property integer $citm_id
 * @property integer $citm_cart_id
 * @property integer $citm_item_id
 * @property double $citm_price
 * @property double $citm_discount
 * @property integer $citm_color
 * @property integer $citm_pattern
 * @property integer $citm_fabric
 * @property integer $citm_type
 * @property string $citm_customization
 * @property string $citm_measurement
 * @property integer $citm_rental
 * @property string $citm_created
 * @property string $citm_modified
 */
class CartItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cart_items}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('citm_cart_id, citm_price', 'required'),
			array('citm_id, citm_cart_id', 'numerical', 'integerOnly'=>true),
			
			array('citm_discount, citm_color, citm_pattern, citm_fabric, citm_type, citm_customization, citm_measurement, citm_rental, citm_created, citm_modified, citm_qty, citm_item_id,citm_user_measurement_id','safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('citm_id, citm_cart_id, citm_item_id, citm_price, citm_discount, citm_color, citm_pattern, citm_fabric, citm_type, citm_customization, citm_measurement, citm_rental, citm_created, citm_modified', 'safe', 'on'=>'search'),
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
			'cartCartItem'=>array(self::BELONGS_TO, 'Cart','citm_cart_id'),
			'cartItem'=>array(self::BELONGS_TO, 'Items','citm_item_id'),
			'cartUserMeasurement'=>array(self::BELONGS_TO, 'UserMeasurements','citm_user_measurement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'citm_id' => 'Order Id',
			'citm_price' => 'Price',
			'citm_discount' => 'Discount',
			'citm_color' => 'Color',
			'citm_pattern' => 'Pattern',
			'citm_fabric' => 'Fabric',
			'citm_type' => 'Cart Type',
			'citm_customization' => 'Customizations',
			'citm_measurement' => 'Measurements',
			'citm_rental' => 'Rental',
			'citm_created' => 'Order Date'			
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
		//$criteria->condition = '';
		$criteria->order = 'citm_cart_id DESC';
		$criteria->compare('citm_cart_id',$this->citm_cart_id);
		$criteria->compare('citm_item_id',$this->citm_item_id);
		$criteria->compare('citm_price',$this->citm_price);
		$criteria->compare('citm_discount',$this->citm_discount);
		$criteria->compare('citm_color',$this->citm_color);
		$criteria->compare('citm_pattern',$this->citm_pattern);
		$criteria->compare('citm_fabric',$this->citm_fabric);
		$criteria->compare('citm_type',$this->citm_type);
		$criteria->compare('citm_customization',$this->citm_customization,true);
		$criteria->compare('citm_measurement',$this->citm_measurement,true);
		$criteria->compare('citm_created',$this->citm_created,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

		/*$dataProvider=new CActiveDataProvider('Post', array(
		    'criteria'=>array(
		        'condition'=>'status=1',
		        'order'=>'create_time DESC',
		        'with'=>array('author'),
		    ),
		    'countCriteria'=>array(
		        'condition'=>'status=1',
		        // 'order' and 'with' clauses have no meaning for the count query
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));*/
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CartItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'citm_created',
				'updateAttribute' => 'citm_modified',
				'setUpdateOnCreate'=> true
			)
		);
	}
}
