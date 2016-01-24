<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php 
  		//THEME ASSETS
        $cs = Yii::app()->clientScript;		
  		$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/styles.css')
        // ->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap.min.css')
        ->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap-theme.min.css')
  		->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/ckeditor.js',CClientScript::POS_END)
        ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/adapters/jquery.js',CClientScript::POS_END)
        ->registerCssFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/bootstrap-wysihtml5.css')
        ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/wysihtml5-0.3.0.js',CClientScript::POS_END)
        ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/bootstrap-wysihtml5.js',CClientScript::POS_END)
        // ->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap.min.js',CClientScript::POS_HEAD)
        ->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.countdown.js',CClientScript::POS_HEAD);

      //LOAD JQUERY
  		Yii::app()->clientScript->registerCoreScript('jquery');
      //$cs = Yii::app()->clientScript;   
      //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-1.11.1.js',CClientScript::POS_HEAD);
      //LOAD BOOTSTRAP
      Yii::app()->bootstrap->register();    
  	?>
  </head>
<body>
<div id="wrapper">
<?php  
    $this->beginContent('/layouts/header_paper');
    $this->endContent();                
?>

<div class="container">
  <?php echo $content;?>
</div>

<?php
    $this->beginContent('/layouts/footer');
    $this->endContent();                
?>
</div>
</body>
</html>
<script>
  $(document).ready(function(){
  	<?php if(Yii::app()->user->hasFlash('popupmsg')){?>
        $.jGrowl("<?php echo Yii::app()->user->getFlash('popupmsg'); ?>",{sticky:true,position:'top-right',closer:false});       
    <?php }?>
  });        	
</script>