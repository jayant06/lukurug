<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title> 
        <script type="text/javascript">
          var baseUrl = '<?php echo Yii::app()->baseUrl; ?>/';
        </script>
        <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->baseUrl; ?>/css/custom-styles.css" rel="stylesheet" />
        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        $cs = Yii::app()->clientScript;     
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/ckeditor.js',CClientScript::POS_END)
           ->registerScriptFile(Yii::app()->request->baseUrl.'/vendors/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        ?>
    </head>
    <body>
        <div id="wrapper">
            <?php  
            $this->beginContent('/layouts/header');
            $this->endContent();
            $this->beginContent('/layouts/left_menu');
            $this->endContent();                
            ?>
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <?php echo CHtml::encode($this->pageTitle); ?> 
                            </h1>
                        </div>
                    </div>
                    <?php
                    //$this->beginContent('/layouts/top_menu');
                    //$this->endContent();
                    ?>                
                    <div class="row">
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
                    <?php  
                    $this->beginContent('/layouts/footer');
                    $this->endContent();                
                    ?>
                </div>            
            </div>        
        </div>    
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.metisMenu.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/custom-scripts.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js"></script>
    </body>    
</html>