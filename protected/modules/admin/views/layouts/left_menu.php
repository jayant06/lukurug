<?php
$controller = ucfirst(strtolower($this->getId()));        
$action = ucfirst(strtolower($this->getAction()->getId()));
$page = $controller.$action;
$userlist = '';
$dashboard = '';
$cmspage = '';
$emailmanager = '';
$categories = '';
$sitesetting = '';
$subcategories = '';
$userlist = '';
$exams = '';
$questions = '';
$states = '';
if($page=='UserIndex')
    $dashboard = 'active-menu';
else if($page=='UserUserlist' || $page=='UserAdd' || $page=='UserEdit')
    $userlist = 'active-menu';
else if($page=='CmspageIndex')
    $cmspage = 'active-menu';
else if($page=='EmailmanagerIndex')
    $emailmanager = 'active-menu';
else if($page=='CategoriesIndex' || $page=='CategoriesCreate' || $page=='CategoriesUpdate')
    $categories = 'active-menu';
else if($page=='ExamsIndex' || $page=='ExamsCreate' || $page=='ExamsUpdate')
    $exams = 'active-menu';
else if($page=='QuestionsIndex' || $page=='QuestionsCreate' || $page=='QuestionsUpdate')
    $questions = 'active-menu';
else if($page=='SubcategoriesIndex' || $page=='SubcategoriesCreate' || $page=='SubcategoriesUpdate')
    $subcategories = 'active-menu';
else if($page=='UserSitesettings')
    $sitesetting = 'active-menu';
else if($page=='StatesIndex')
    $states = 'active-menu';
?>
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-dashboard"></i> Dashboard',array('/admin/user/index'),array('class' => $dashboard));
                ?>                
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-user"></i> User Manager',array('/admin/user/userlist'),array('class' => $userlist));
                ?>                
            </li>
            <li>
                <a href="javascript:void(0);"><i class="fa fa-sitemap"></i>&nbsp;Courses</a>
                <ul>
                    <li class="courceMenus">
                        <?php
                        echo CHtml::link('Main Courses',array('/admin/categories/index','type' => 1));
                        ?>
                    </li>
                    <li class="courceMenus">
                        <?php
                        echo CHtml::link('Sub Courses',array('/admin/categories/index','type' => 2));
                        ?>
                    </li>
                    <li class="courceMenus">
                        <?php
                        echo CHtml::link('Courses',array('/admin/categories/index','type' => 3));
                        ?>
                    </li>
                </ul>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-sitemap"></i> States',array('/admin/states/index'),array('class' => $states));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-file-text"></i> Exams',array('/admin/exams/index'),array('class' => $exams));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-file-text"></i> Questions',array('/admin/questions/index'),array('class' => $questions));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-envelope-o"></i> Email Manager',array('/admin/emailmanager/index'),array('class' => $emailmanager));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-file-text"></i> CMS Pages',array('/admin/cmspage/index'),array('class' => $cmspage));
                ?>
            </li>
            <!-- <li>
                <?php
                //echo CHtml::link('<i class="fa fa-sun-o"></i> Site Settings',array('/admin/user/sitesetting'),array('class' => $sitesetting));
                ?>
            </li>             -->
        </ul>
    </div>
</nav>