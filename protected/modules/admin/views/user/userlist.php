<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
                <div style="float:left;">Users</div>
                <div style="float:right">
                  <?php
                  echo CHtml::link('Add User',array('/admin/user/add'),array('class' => 'btn btn-primary'));
                  ?>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="panel-body"> 
              <?php
              $this->widget('bootstrap.widgets.TbGridView', array(
                  'id'=>'maker-grid',
                  'type'=>'bordered striped',
                  'dataProvider' => $model->userlist(),                           
                  'template'=>"{items}{summary}{pager}",
                  'filter'=>$model,                
                  'columns'=>array(
                    array(
                      'name'=>'u_first_name',
                      'type'=>'raw',
                      'value'=>'CHtml::encode($data->u_first_name)'
                    ),
                    array(
                      'name'=>'u_last_name',
                      'type'=>'raw',
                      'value'=>'CHtml::encode($data->u_last_name)'
                    ),                  
                    array(
                      'name'=>'u_email',
                      'type'=>'raw',
                      'value'=>'CHtml::encode($data->u_email)'
                    ),                                                  
                    array(
                      'name'=>'u_status',
                      'type'=>'raw',
                      'value'=>'CHtml::link(($data->u_status==1)?"Activated":"Deactived",Yii::app()->createUrl("/admin/user/status", array("id"=>$data->u_id,"status"=>$data->u_status)),array("gridid"=>"maker-grid","class"=>"statusupdate","title"=>($data->u_status==1)?"Deactive User":"Activate User"))',
                      'filter'=>false,                    
                    ),
                    array(
                      'name'=>'u_created',
                      'header'=>'Sign-up Date',
                      'type'=>'raw',
                      'value'=>'CHtml::encode(date("Y-m-d",strtotime($data->u_created)))',
                      'filter'=>false,                    
                    ),
                    array(
                      'header'=>'Action',
                      'class'=>'CButtonColumn',                                   
                      'template'=>'{update}',
                      'htmlOptions'=>array('style'=>'width:70px;'),                                                            
                      'buttons'=>array(
                        'update'=>array(
                          'label'=>'Edit',                            
                          'imageUrl'=>false,
                          'url'=>'Yii::app()->createUrl("/admin/user/edit/".$data->u_id)',                                                                        
                        ),
                      )
                    )    
                  ),
              ));         
            ?>
            </div>
        </div>
    </div>
</div>
<script>
  $('.statusupdate').live('click',function(e){
    var grid = $(this).attr("gridid");
    $.ajax({
      url:$(this).attr('href'),
      success:function(){
        $.fn.yiiGridView.update(grid);
      },      
    });
    return false;
  });
</script>