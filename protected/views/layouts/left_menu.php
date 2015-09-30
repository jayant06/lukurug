<?php           
    
    $this->widget('zii.widgets.CMenu',array(
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
)); ?>