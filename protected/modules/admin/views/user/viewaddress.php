<style type="text/css">
	.panel-body ul li{
		list-style: none;
		line-height: 30px;
	}
	.panel-body ul li span1{
		display: inline-block;
		width: 30%;
		font-weight: bold;
	}
	.panel-body ul li span2{
		display: inline-block;
		width: 68%;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div style="float:left;">View Billing / Shipping Address</div>
                <div style="float:right;"><a href="javascript:history.go(-1);">Back</a></div>
                <div style="clear:both;"></div>
            </div>
            <div class="panel-body">
            	<?php
            	if(!empty($model)){
            		foreach ($model as $key => $arr) {
            			?>
            			<h3><?php echo ($arr->uad_type==2) ? 'Billing Address' : 'Shipping Address'; ?></h3>
            			<hr>
		            	<div>
		            		<ul>
		            			<li>
		            				<span1>Address Line 1: </span1>
		            				<span2><?php echo $arr->uad_add1; ?></span2>
		            			</li>
		            			<li>
		            				<span1>Address Line 2: </span1>
		            				<span2><?php echo $arr->uad_add2; ?></span2>
		            			</li>
		            			<li>
		            				<span1>Country: </span1>
		            				<span2><?php echo $arr->userAddCountry->cnt_name; ?></span2>
		            			</li>
		            			<li>
		            				<span1>State/Province: </span1>
		            				<span2><?php echo $arr->userAddState->st_name; ?></span2>
		            			</li>
		            			<li>
		            				<span1>City: </span1>
		            				<span2><?php echo $arr->uad_city; ?></span2>
		            			</li>
		            			<li>
		            				<span1>Zip: </span1>
		            				<span2><?php echo $arr->uad_zipcode; ?></span2>
		            			</li>
		            			<li>
		            				<span1>Mobile: </span1>
		            				<span2><?php echo $arr->uad_mobile; ?></span2>
		            			</li>
		            		</ul>
		            	</div>
		            	<?php
            		}
            	}
            	?>            	
            </div>
        </div>
    </div>
</div>