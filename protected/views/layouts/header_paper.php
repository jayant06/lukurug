<div style="height:122px; padding-top:5px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div style="float:left;"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/logo-adarsh-gurukul.png','Gurukul',array('width'=>150)),array('/')); ?></div>
                <div style="float:left;"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/aadarsh-gurukul.png','Gurukul',array('width'=>350)),array('/')); ?></div>
                <div style="float:right;"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/glob.jpg','Gurukul',array('width'=>70)),array('/')); ?></div>

                <div style="font-weight: bold;color: red;" align="right">
                    <marquee direction="left"> Contact: 9829198118</marquee >
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <?php echo CHtml::link(Yii::app()->params['title'],array('/'),array('class'=>'navbar-brand')); ?>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <?php if(!Yii::app()->user->isGuest){ ?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Exam/Test <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo CHtml::link('Attempted Exam',array('/exam/attempted')); ?></li>
                        <li><?php echo CHtml::link('Upcoming Exam',array('/exam/upcoming')); ?></li>
                    </ul>
                </li>
            <?php }?>
            <?php if(Yii::app()->user->isGuest){ ?>
                <li><?php echo CHtml::link('Sign In',array('site/login'));?></li>
            <?php }else {?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucwords($this->loggedusername);?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo CHtml::link('Profile',array('/user/profile')); ?></li>
                        <li><?php echo CHtml::link('Change Password',array('/user/changepassword')); ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?php echo CHtml::link('Logout',array('/site/logout')); ?></li>
                    </ul>
                </li>
            <?php }?>
        </ul>
      </div>
    </div>
</nav> -->