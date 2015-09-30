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
else if($page=='SubcategoriesIndex' || $page=='SubcategoriesCreate' || $page=='SubcategoriesUpdate')
    $subcategories = 'active-menu';
else if($page=='UserSitesettings')
    $sitesetting = 'active-menu';
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
                <?php
                echo CHtml::link('<i class="fa fa-sitemap"></i> Courses',array('/admin/categories/index'),array('class' => $categories));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-file-text"></i> Exams',array('/admin/exams/index'),array('class' => $exams));
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