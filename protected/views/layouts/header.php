<?php 
$categories = Categories::model()->findAll();
$productMenues = array();
$index = 0;
if(!empty($categories)){
    foreach ($categories as $key => $catObj) {
        $i = 0;
        $productMenues['label']              = $catObj->cat_name;
        $productMenues['url']                = '#'; 
        $productMenues['items'][$i]['label'] = 'All Products';   
        $productMenues['items'][$i]['url']   = array('products/');    
        if(!empty($catObj->catSubcats)){
            foreach ($catObj->catSubcats as $key2 => $subcatObj) {
                $i++;
                $productMenues['items'][$i]['label'] = $subcatObj->sub_cat_name;   
                $productMenues['items'][$i]['url']   = array('products/index/'.$subcatObj->sub_id);                   
            }            
        }
        $index++;
    }    
}
//prd($productMenues);
/*<a data-toggle="modal" href="remote.html" data-target="#modal">Click me</a>*/
$this->widget('bootstrap.widgets.TbNavbar', array(    
    //'type'=>'inverse', // null or 'inverse'
    'brand'=> Yii::app()->params['title'],
    'brandUrl'=>array('/'),
    'collapse'=>true, // requires bootstrap-responsive.css
    'fluid'=>true,    
    'items'=>array(        
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(        
               array('label'=>'Signin', 'visible'=>Yii::app()->user->isGuest,'url'=>array('site/login')),
                array('label'=>'Signup', 'visible'=>Yii::app()->user->isGuest,'url'=>array('user/signup')),
                array('label'=>$this->loggedusername, 'visible'=>Yii::app()->user->checkAccess('member'), 'url'=>'#', 'items'=>array(
                    array('label'=>'Dashboard', 'url'=>array('user/dashboard')),
                    array('label'=>'Profile', 'url'=>array('user/profile')),                    
                    array('label'=>'Change Password', 'url'=>array('user/changepassword')),
                    '---',
                    array('label'=>'Logout', 'url'=>array('site/logout')),
                )),
            ),
        ),
    ),

)); ?>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div style="margin:0 2% 0 2%;font-weight: bold;color: red;" align="right">
    <marquee direction="left"> Contact: 9829198118</marquee >
</div>
<div>&nbsp;</div>