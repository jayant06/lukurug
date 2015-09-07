<style type="text/css">
  .products li{
    border: 4px solid #eee;
    border-radius: 5px;
    display: inline-block;
    margin: 5px;
    padding: 5px;
    text-align: center;
    width: 22%;
  }
</style>
<ul class="products">
  <?php      
  $this->widget('zii.widgets.CListView', array(
    'id'=>'products-grid',
    'dataProvider'=>$model->search(),                       
    'template'=>'{items}{pager}',        
    'itemView'=>'_products',   		
    //'emptyText'=>($model->un_content=='')?'No Notes Found':'No notes found for the keyword "<b>'.$model->un_content.'</b>"',
    'summaryText'=>'Showing {start} to {end} of {count} entries',       
  ));        
  ?>
</ul>