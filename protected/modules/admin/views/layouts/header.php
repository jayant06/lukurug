<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html"><?php echo Yii::app()->params['title']; ?></a>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><?php echo CHtml::link('<i class="fa fa-user fa-fw"></i> Profile',array('user/profile')); ?>
                </li>
                <li>
                    <?php echo CHtml::link('<i class="fa fa-gear fa-fw"></i> Changepassword',array('user/changepassword'));?>
                </li>
                <li class="divider"></li>
                <li>
                    <?php echo CHtml::link('<i class="fa fa-sign-out fa-fw"></i> Logout',array('user/logout')); ?>
                </li>
            </ul>            
        </li>        
    </ul>
</nav>
