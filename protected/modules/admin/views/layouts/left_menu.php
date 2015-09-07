<?php
$controller = ucfirst(strtolower($this->getId()));        
$action = ucfirst(strtolower($this->getAction()->getId()));
$page = $controller.$action;
$userlist = '';
$dashboard = '';
$cmspage = '';
$emailmanager = '';
$categories = '';
$fabric = '';
$buttons = '';
$seoPages = '';
$sitesetting = '';
$subcategories = '';
$items = '';
$userlist = '';
$orders = '';
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
else if($page=='SubcategoriesIndex' || $page=='SubcategoriesCreate' || $page=='SubcategoriesUpdate')
    $subcategories = 'active-menu';
else if($page=='FabricsIndex' || $page=='FabricsCreate' || $page=='FabricsUpdate')
    $fabric = 'active-menu';
else if($page=='ButtonsIndex' || $page=='ButtonsCreate' || $page=='ButtonsUpdate')
    $buttons = 'active-menu';
else if($page=='SeopagesIndex' || $page=='ButtonsUpdate')
    $seoPages = 'active-menu';
else if($page=='UserSitesettings')
    $sitesetting = 'active-menu';
else if($page=='ItemsIndex')
    $sitesetting = 'active-menu';
else if($page=='ItemsOrders')
    $orders = 'active-menu';
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
                echo CHtml::link('<i class="fa fa-sitemap"></i> Categories',array('/admin/categories/index'),array('class' => $categories));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-tasks"></i> Products',array('/admin/items/index'),array('class' => $items));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-tasks"></i> Fabrics',array('/admin/fabrics/index'),array('class' => $fabric));
                ?>
            </li>            
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-times-circle-o"></i> Buttons',array('/admin/buttons/index'),array('class' => $buttons));
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
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-tags"></i> Seo Manager',array('/admin/seopages/index'),array('class' => $seoPages));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link('<i class="fa fa-sun-o"></i> Site Settings',array('/admin/user/sitesetting'),array('class' => $sitesetting));
                ?>
            </li>
            <!-- <li>
                <a href="#"><i class="fa fa-sitemap"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Second Level Link</a>
                    </li>
                    <li>
                        <a href="#">Second Level Link</a>
                    </li>
                    <li>
                        <a href="#">Second Level Link<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>

                        </ul>

                    </li>
                </ul>
            </li> -->            
        </ul>
    </div>
</nav>

<?php           
    
    /*$this->widget('zii.widgets.CMenu',array(
        'encodeLabel' => false,
        'htmlOptions'=>array(
            'class'=>'nav bs-docs-sidenav nomargin'
        ),
        'activeCssClass'=>'active',
        'items'=>array(
            array('label'=>'<i class="icon-chevron-right"></i> Dashboard', 'url'=>array('/admin/user/index')),
            array('label'=>'<i class="icon-chevron-right"></i> Manage Users', 'url'=>array('/admin/user/userlist')),
            array('label'=>'<i class="icon-chevron-right"></i> Cms Pages', 'url'=>array('/admin/cmspage/index')),            
            array('label'=>'<i class="icon-chevron-right"></i> Email Manager', 'url'=>array('/admin/emailmanager/index')),
            //array('label'=>'<i class="icon-chevron-right"></i> Invoice Template', 'url'=>array('/admin/invoicetemplate/index')),
            array('label'=>'<i class="icon-chevron-right"></i> Contract Template', 'url'=>array('/admin/contract'),'active'=>Yii::app()->controller->route=='admin/invoicetemplate/contract'),
            array('label'=>'<i class="icon-chevron-right"></i> Site Settings', 'url'=>array('/admin/user/sitesetting')),
            array('label'=>'<i class="icon-chevron-right"></i> Manage FAQs', 'url'=>array('/admin/faq/index')),
            array('label'=>'<i class="icon-chevron-right"></i> <span class="badge badge-important pull-right">'.Yii::app()->params['unread_message'].'</span> Messages', 'url'=>array('/admin/user/messages')),
            array('label'=>'<i class="icon-chevron-right"></i> Fund Request', 'url'=>array('/admin/user/fundrequest')),
            array('label'=>'<i class="icon-chevron-right"></i> User Transactions', 'url'=>array('/admin/user/accounts')),
        ),
));*/ ?>