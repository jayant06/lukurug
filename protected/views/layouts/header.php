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
                /*$productMenues,
                array('label' => 'Customize', 'url' => '#','items' => array(
                    array('label'=>'Shirt', 'url'=>array('fabrics/index/1')),
                    array('label'=>'Trouser', 'url'=>array('fabrics/index/2')),                    
                    array('label'=>'Blazer', 'url'=>array('/fabrics/index/3')),
                )),
                array('label'=>'My Cart Item(s)', 'url'=>'javascript:void(0);','itemOptions' => array('href' => Yii::app()->baseUrl.'/cartitems','data-toggle' => 'modal' ,'data-target' => '#cartModal')),*/
                
                array('label'=>'Signin', 'visible'=>Yii::app()->user->isGuest,'url'=>array('site/login')),
                array('label'=>'Signup', 'visible'=>Yii::app()->user->isGuest,'url'=>array('user/signup')),
                array('label'=>$this->loggedusername, 'visible'=>Yii::app()->user->checkAccess('member'), 'url'=>'#', 'items'=>array(
                    array('label'=>'Dashboard', 'url'=>array('user/dashboard')),
                    array('label'=>'Profile', 'url'=>array('user/profile')),                    
                    //array('label'=>'Editor', 'url'=>array('/editor')),
                	array('label'=>'Change Password', 'url'=>array('user/changepassword')),
                    '---',
                    array('label'=>'Logout', 'url'=>array('site/logout')),
                )),
            ),
        ),
    ),

)); ?>
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Items in your cart</h4>
      </div>
      <div class="modal-body">
          
      </div>       
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("a[data-target=#cartModal]").click(function(ev) {
            ev.preventDefault();
            var target = $(this).attr("href");
            // load the url and show modal on success
            $("#cartModal .modal-body").load(target, function() { 
                 $("#cartModal").modal("show"); 
            });
        });
    });
</script>
