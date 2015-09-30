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
  <body id="login">
    <?php  
        $this->beginContent('/layouts/header');
        $this->endContent();                
    ?>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div class="container">           
     <?php echo $content; ?>
    </div>    
  </body>
</html>
