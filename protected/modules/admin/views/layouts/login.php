<!DOCTYPE html>
<html>
  <head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php 
  		Yii::app()->bootstrap->register();    
  		$cs = Yii::app()->clientScript;		
  		$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/styles.css');
  	?>
  </head>
  <body id="login" class="loginbody">
    <div class="container" style="margin-top:10%;">           
     <?php echo $content; ?>
    </div>    
  </body>
</html>