<?php
function pr($arr){
	echo '<pre>';	
	print_r($arr);
	echo '</pre>';	
}

function prd($arr){
	echo '<pre>';	
	print_r($arr);
	echo '</pre>';
	exit;
}
date_default_timezone_set('GMT');
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
