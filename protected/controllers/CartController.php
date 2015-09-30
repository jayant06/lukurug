<?php
class CartController extends Controller
{
	public $layout='main';

	public function actionAddtocart(){
		$this->layout = false;
		$model = new Cart;
		if(!empty($_POST)){
			$data = array();
			unset($_POST['YII_CSRF_TOKEN']);
			$_POST['qty'] = 1;
			$data = Yii::app()->session['cartItems'];
			if(!empty($_POST['txt_fabric']))
				$data['fabric'][$_POST['txt_fabric']] = $_POST;
			if(!empty($_POST['itemid']))
				$data['item'][$_POST['itemid']] = $_POST;
			Yii::app()->session['cartItems'] = $data;			
		}
		echo 'success';
		exit;		
	}	

	public function actionView(){
		$this->layout = false;
		$cart_items = Yii::app()->session['cartItems'];
		$cartData = $this->processCart();
		$this->render('view',array('fabrics' => $cartData['fabrics'],'items' => $cartData['items'],'cart_items' => $cart_items));
	}

	public function actionRemoveitem(){
		$this->layout = false;
		$cart_items = Yii::app()->session['cartItems'];
		if(!empty($_POST['id']) && !empty($_POST['type'])){
			if($_POST['type']=='item'){
				unset($cart_items['item'][$_POST['id']]);
			}
			if($_POST['type']=='fabric'){
				unset($cart_items['fabric'][$_POST['id']]);
			}
		}
		Yii::app()->session['cartItems'] = $cart_items;
		echo 'succes';	
		exit;	
	}

	public function actionUpdateqty(){
		$this->layout = false;
		$cart_items = Yii::app()->session['cartItems'];
		if(!empty($_POST['id']) && !empty($_POST['qty'])){
			if($_POST['type']=='item'){
				foreach ($cart_items['item'] as $itmKey => $itemArr) {
					if($itmKey==$_POST['id']){
						$itemArr['qty'] = $_POST['qty'];
						$cart_items['item'][$itmKey] = $itemArr;
					}
				}
			}
			if($_POST['type']=='fabric'){
				foreach ($cart_items['fabric'] as $fabKey => $fabArr) {
					if($fabKey==$_POST['id']){
						$fabArr['qty'] = $_POST['qty'];
						$cart_items['fabric'][$fabKey] = $fabArr;
					}
				}	
			}
		}
		Yii::app()->session['cartItems'] = $cart_items;
		echo 'succes';	
		exit;
	}

	public function actionCheckout(){  
		$itemData = $this->processItems();
		// set 
		$paymentInfo['Order']['theTotal'] = $itemData['total'];
		$paymentInfo['Order']['description'] = implode(', ',$itemData['itemDetails']);
		$paymentInfo['Order']['quantity'] = $itemData['qty'];
		//prd($paymentInfo);
		$this->saveOrders(0,array('status' => 'not checkout yet'));
		// call paypal 
		$result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo); 

		//Detect Errors 
		if(!Yii::app()->Paypal->isCallSucceeded($result)){ 
			if(Yii::app()->Paypal->apiLive === true){
				//Live mode basic error message
				$error = 'We were unable to process your request. Please try again later';
			}else{
				//Sandbox output the actual error message to dive in.
				$error = $result['L_LONGMESSAGE0'];
			}
			echo $error;
			Yii::app()->end();			
		}else { 
			// send user to paypal 
			$token = urldecode($result["TOKEN"]); 			
			Yii::app()->session['paypaltoken'] = $result["TOKEN"];
			$payPalURL = Yii::app()->Paypal->paypalUrl.$token; 
			$this->saveOrders(1,$result);
			$this->redirect($payPalURL); 
		}
	}

	public function actionConfirm(){
		$itemData = $this->processItems();
		$token = trim($_GET['token']);
		$payerId = trim($_GET['PayerID']);		
		
		$result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);
		
		$result['PAYERID'] = $payerId; 
		$result['TOKEN'] = $token; 
		$result['ORDERTOTAL'] = $itemData['total'];

		//Detect errors 
		if(!Yii::app()->Paypal->isCallSucceeded($result)){ 
			if(Yii::app()->Paypal->apiLive === true){
				//Live mode basic error message
				$error = 'We were unable to process your request. Please try again later';
			}else{
				//Sandbox output the actual error message to dive in.
				$error = $result['L_LONGMESSAGE0'];
			}
			echo $error;
			Yii::app()->end();
		}else{ 			
			$paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
			//Detect errors  
			if(!Yii::app()->Paypal->isCallSucceeded($paymentResult)){
				if(Yii::app()->Paypal->apiLive === true){
					//Live mode basic error message
					$error = 'We were unable to process your request. Please try again later';
				}else{
					//Sandbox output the actual error message to dive in.
					$error = $paymentResult['L_LONGMESSAGE0'];
				}
				echo $error;
				Yii::app()->end();
			}else{
				//payment was completed successfully
				$this->saveOrders(2,$paymentResult);
				Yii::app()->session['cartItems'] = array();
				Yii::app()->session['cartId'] = '';
				$this->render('confirm');
			}			
		}
	}
        
    public function actionCancel(){
		//The token of the cancelled payment typically used to cancel the payment within your application
		prd($_REQUEST);
		$token = $_GET['token'];	
		$result = array('status' => 'cancel','token' => $token);	
		$this->saveOrders(3,$result);
		Yii::app()->session['cartItems'] = array();
		Yii::app()->session['cartId'] = '';
		$this->redirect('cancel');
	}

	public function saveOrders($status,$result){
		$cart = new Cart;
		$user_Id = Yii::app()->user->id;
		if(!empty($user_Id)){
			$cartData = $this->processCart();
			$cart_items = Yii::app()->session['cartItems'];
			$cart->cart_orderno = uniqid();
			$cart->cart_payment_status = $status;
			$cart->cart_order_status = 0;
			$cart->cart_user_id = $user_Id;
			$cart->cart_paypal_result = json_encode($result);
			$sessCartId = Yii::app()->session['cartId'];
			if(!empty($sessCartId)){
				$cart->cart_id = Yii::app()->session['cartId'];
				$cart->isNewRecord = false;
			}
			if($cart->save() && empty($sessCartId)){
				Yii::app()->session['cartId'] = $cart->cart_id;
				if(!empty($cartData['fabrics'])){
					foreach ($cartData['fabrics'] as $key => $arrObj) {
						$cartItemsModel = new CartItems;
						$fabId = $arrObj->fab_id;
						
						$shirtArr = array();
						$trouserArr = array();
						$suitArr = array();
						$blazerArr = array();
						if($arrObj->fab_for==1){
							$shirtArr = array(
								'sleeve' => $cart_items['fabric'][$fabId]['txt_sleeve'],
								'collor' => $cart_items['fabric'][$fabId]['txt_collor'],
								'cuff' => $cart_items['fabric'][$fabId]['txt_cuff'],
								'placket' => $cart_items['fabric'][$fabId]['txt_placket'],
								'pocket' => $cart_items['fabric'][$fabId]['txt_pocket'],
								'back_shirt' => $cart_items['fabric'][$fabId]['txt_back_shirt'],
								'front_shirt' => $cart_items['fabric'][$fabId]['txt_front_shirt'],
								'button' => $cart_items['fabric'][$fabId]['txt_button'],
								'monogram' => $cart_items['fabric'][$fabId]['txt_monogram'],
								'fabid' => $cart_items['fabric'][$fabId]['txt_fabric']
							);							
						}else if($arrObj->fab_for==2){
							$trouserArr = array(
								'belt' => $cart_items['fabric'][$fabId]['txt_belt'],
								'pleated' => $cart_items['fabric'][$fabId]['txt_pleated'],
								'sidepocket' => $cart_items['fabric'][$fabId]['txt_sidepocket'],
								'backpocket' => $cart_items['fabric'][$fabId]['txt_backpocket'],
								'bottomstyle' => $cart_items['fabric'][$fabId]['txt_bottomstyle'],
								'back_lining' => $cart_items['fabric'][$fabId]['txt_lining'],
								'button' => $cart_items['fabric'][$fabId]['txt_button'],
								'fabid' => $cart_items['fabric'][$fabId]['txt_fabric']
							);
						}else if($arrObj->fab_for==3){
							$blazerArr = array();
						}

						$customizations = array(
							'product' => $arrObj->fab_for,
							'shirt' => $shirtArr,
							'trouser' => $trouserArr,
							'blazer' => $blazerArr,
							'suit' => $suitArr
						);
						$customization_json = json_encode($customizations);

						$cartItemsModel->citm_cart_id = $cart->cart_id;
						$cartItemsModel->citm_color = $arrObj->fab_color;
						$cartItemsModel->citm_pattern = $arrObj->fab_pattern;
						$cartItemsModel->citm_fabric = $arrObj->fab_fabric;
						$cartItemsModel->citm_customization = $customization_json;
						//$cartItemsModel->citm_measurement
						$cartItemsModel->citm_type = 2;
						$cartItemsModel->citm_price = $arrObj->fab_price;
						//$cartItemsModel->citm_discount = 0;
						$cartItemsModel->citm_qty = $cart_items['fabric'][$fabId]['qty'];							
						//$cartItemsModel->citm_rental	
						//$errors = $cartItemsModel->getErrors();
						//prd($errors);
						if(!empty($cart_items['fabric'][$fabId]['user_measurement_id'])){
							$cartItemsModel->citm_user_measurement_id = $cart_items['fabric'][$fabId]['user_measurement_id'];
						}
						
						$cartItemsModel->isNewRecord = true;
						$cartItemsModel->save();
					}
				}

				if(!empty($cartData['items'])){
					foreach ($cartData['items'] as $key1 => $arrObj1) {
						$cartItemsModel = new CartItems;
						$itemid = $arrObj1->itm_id;
						$cartItemsModel->citm_cart_id = $cart->cart_id;							
						$cartItemsModel->citm_item_id = $arrObj1->itm_id;
						$cartItemsModel->citm_type = '0';							
						$cartItemsModel->citm_price = $arrObj1->itm_price;
						//$cartItemsModel->citm_discount = 0;
						$cartItemsModel->citm_qty = $cart_items['item'][$itemid]['qty'];				
						//$cartItemsModel->citm_rental		
						//$errors = $cartItemsModel->getErrors();
						//pr($errors);
						$cartItemsModel->isNewRecord = true;
						$cartItemsModel->save();
					}
				}					
			}
		}
	}

	public function processCart(){
		$cart_items = Yii::app()->session['cartItems'];
		$fabrics = array();
		$items = array();
		if(!empty($cart_items)){
			$fabricIds = array();
			$itemIds = array();
			foreach ($cart_items as $key => $cartArr) {
				if($key == 'fabric'){
					foreach ($cartArr as $fabId => $fabArr) {
						$fabricIds[] = $fabId;
					}
				}
				if($key == 'item'){
					foreach ($cartArr as $itemId => $itemArr) {
						$itemIds[] = $itemId;
					}
				}
			}
			
			$fabCriteria = new CDbCriteria;
			$itmCriteria = new CDbCriteria;

			$fabIds = '';
			if(!empty($fabricIds)){
				$fabIds = implode(',', $fabricIds);
				$fabCriteria->condition = 'fab_id in ('.$fabIds.')';
				$fabrics = Fabrics::model()->findAll($fabCriteria);				
			}

			$itmIds = '';
			if(!empty($itemIds)){
				$itmIds = implode(',', $itemIds);
				$itmCriteria->condition = 'itm_id in ('.$itmIds.')';
				$items = Items::model()->findAll($itmCriteria);
			}
		}

		$data['items'] = $items;
		$data['fabrics'] = $fabrics;

		return $data;
	}

	private function processItems(){
		$cartData = $this->processCart();
		$cart_items = Yii::app()->session['cartItems'];
		//prd($cartData);
		$total = 0;
		$qtyTotal = 0;
		$itemNames = array();
		if(!empty($cartData['items'])){
			foreach ($cartData['items'] as $itemKey => $itemArr) {
				if(!empty($itemArr->itm_price)){
					$qty = $cart_items['item'][$itemArr->itm_id]['qty'];
					$price = $itemArr->itm_price;
					$total += ($qty*$price);
					$qtyTotal += $qty;
					$itemNames[] = $itemArr->itm_name." x ".$qty;
				}
			}
		}
		if(!empty($cartData['fabrics'])){
			foreach ($cartData['fabrics'] as $fabricKey => $fabArr) {
				if(!empty($fabArr->fab_price)){
					$qty = $cart_items['fabric'][$fabArr->fab_id]['qty'];
					$price = $fabArr->fab_price;
					$total += ($qty*$price);
					$qtyTotal += $qty;	
					$itemNames[] = $fabArr->fab_name." x ".$qty;
				}
			}
		}

		$data = array('total' => $total,'qty' => $qtyTotal, 'itemDetails' => $itemNames);
		return $data;
	}

	public function actionUpdateusermeasurement(){
		$this->layout = false;
		$cart_items = Yii::app()->session['cartItems'];
		if(!empty($_POST['fabid'])){
			$fabid = $_POST['fabid'];
			$id = $_POST['id'];
			$cart_items['fabric'][$fabid]['user_measurement_id'] = $id;			
		}
		Yii::app()->session['cartItems'] = $cart_items;
		echo 'success';
		exit;
	}
}