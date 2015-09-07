<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript">
      var baseUrl = '<?php echo Yii::app()->baseUrl; ?>/';
    </script>
    <?php 
  		//THEME ASSETS
      $cs = Yii::app()->clientScript;		
  		$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/styles.css')      	
  		->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/ckeditor.js',CClientScript::POS_END)
      ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/adapters/jquery.js',CClientScript::POS_END)
      ->registerCssFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/bootstrap-wysihtml5.css')
      ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/wysihtml5-0.3.0.js',CClientScript::POS_END)
      ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/wysiwyg/bootstrap-wysihtml5.js',CClientScript::POS_END)
      ->registerCssFile(Yii::app()->request->baseUrl.'/css/stylo_se_min.css');
      //LOAD JQUERY
  		Yii::app()->clientScript->registerCoreScript('jquery');
      $cs = Yii::app()->clientScript;   
      $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui.js');
      // For the shirt editor      
      $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lang/se_en.js');
      $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/StyloSEMin.js');
      // $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/indianStyloSEApi.js');
      // For the trouser editor
      $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lang/te_en.js');
      $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/StyloTEMin.js');
      // $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/indianStyloTEApi.js');
      //LOAD BOOTSTRAP
      Yii::app()->bootstrap->register();    
  	?>
  </head>
<body>
<?php  
    $this->beginContent('/layouts/header');
    $this->endContent();                
?>
<div class="container-fluid" style="margin-top:45px;">
  <div class="row-fluid">
      <!-- <div class="span3" id="sidebar">
          <?php  
              //$this->beginContent('/layouts/left_menu');
              //$this->endContent();                
          ?>
      </div> -->
      <div class="span12" id="content">
          <div class="row-fluid">
            <?php if(Yii::app()->user->hasFlash('success')):?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>                              
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php elseif(Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>
          </div>
          <?php echo $content;?>
      </div>
  </div>
  <hr>
  <?php  
    $this->beginContent('/layouts/footer');
    $this->endContent();                
  ?>
   </div>
</body>
</html>
<script>
  $(document).ready(function(){
  	/*$.scribitz.init({
			'baseUrl' 	: '<?php echo Yii::app()->request->baseUrl.'/'; ?>',			
			'TimeOffSet' :'<?php echo Yii::app()->session['TimeOffSet']; ?>',
			'admin':false
	  });*/ 	
    <?php if(Yii::app()->user->hasFlash('popupmsg')){?>
        $.jGrowl("<?php echo Yii::app()->user->getFlash('popupmsg'); ?>",{sticky:true,position:'top-right',closer:false});       
    <?php }?>
  });        	
</script>