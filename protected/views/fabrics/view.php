<style type="text/css">
  .fabrics li,.buttons li{
    border: 4px solid #eee;
    border-radius: 5px;
    display: inline-block;
    margin: 5px;
    padding: 5px;
    text-align: center;
    width: 22%;
    height: 150px;
  }
  .fabrics li.selected,.buttons li.selected{
  	background: #CCC;
  }
  .fabricTabs{
  	width: 350px;  	
  	margin: 0px;
  }
  .fabricTabs li{
  	padding: 5px;
  	border-radius: 5px;
  	min-width: 100px;
  	text-align: center;
  	display: inline-block;
  	border: 1px solid #CCC;
  	background: #EEE;
  	cursor: pointer;
  }
  .fabricTabs li.selected{
  	background: #CCC !important;
  }
  .fabricFilters li{
    display: inline-block;
  }
  .fabricFilters li select{
    width: 150px;
  }
  .view_summery_details{
    display: none;
  }
  .view_summery_details li{
    line-height: 42px;
    list-style: none;
  }
</style>

<div style="width:39%;float:left;border:1px solid #ccc;min-height:500px;border-radius:5px;margin-right:10px;padding:5px;">
	<div>&nbsp;</div>
	<div align="center">
		<div>
          <ul class="fabricTabs">
      			<li class="selected" rel="fabrics">FABRIC</li>
      			<li rel="style">STYLE</li>
      			<li rel="buttons">BUTTONS</li>
      		</ul>
        </div>    
	</div>

	<div id="fabrics">

        <div>&nbsp;</div>

        <div>
          <ul class="fabricFilters">
            <li>
              <select name="fabric_patterns" id="fabric_patterns">
                <option value="">All Patterns</option>
                <?php
                foreach (Yii::app()->params['fabPattern'] as $pKey => $pattern) {
                  ?>
                  <option value="<?php echo $pKey; ?>"><?php echo $pattern; ?></option>
                  <?php
                }
                ?>
              </select>
            </li>
            <li>
              <select name="fabric_all" id="fabric_all">
                <option value="">All Fabrics</option>
                <?php
                foreach (Yii::app()->params['fabrics'] as $fKey => $fabricname) {
                  ?>
                  <option value="<?php echo $fKey; ?>"><?php echo $fabricname; ?></option>
                  <?php
                }
                ?>
              </select>
            </li>
            <li>
              <select name="fabric_colors" id="fabric_colors">
                <option value="">All Colors</option>
                <?php
                foreach (Yii::app()->params['fabColors'] as $fcKey => $fabriccolor) {
                  ?>
                  <option value="<?php echo $fcKey; ?>"><?php echo $fabriccolor; ?></option>
                  <?php
                }
                ?>
              </select>
            </li>
          </ul>
        </div>

        <div>&nbsp;</div>
        <div>
      		<ul class="fabrics">
      		  <?php      
      		  $this->widget('zii.widgets.CListView', array(
      		    'id'=>'fabrics-grid',
      		    'dataProvider'=>$model->search(),                       
      		    'template'=>'{items}{pager}',        
      		    'itemView'=>'_fabrics',   
      		    'viewData' => array('id' => $id),		
      		    //'emptyText'=>($model->un_content=='')?'No Notes Found':'No notes found for the keyword "<b>'.$model->un_content.'</b>"',
      		    'summaryText'=>'Showing {start} to {end} of {count} entries',       
      		  ));        
      		  ?>
      		</ul>
        </div>
	</div>
    <?php if($fabric_for==1){ ?>
    <div id="style" style="display:none;">
        <div id="tabs">
              <ul>
               <!--  <li><a href="#tabs-1">Fabric</a></li> -->
                <li><a href="#tabs-2">Sleeve</a></li>                
                <li><a href="#tabs-3">Collar</a></li>
                <li><a href="#tabs-4">Cuff</a></li>
                <li><a href="#tabs-5">Placket</a></li>
                <li><a href="#tabs-6">Pocket</a></li>
                <li><a href="#tabs-7">Back Detail</a></li>
                <li><a href="#tabs-8">Bottom Cut</a></li>
                <!-- <li><a href="#tabs-9">Buttons</a></li> -->
              </ul>
              <div id="tabs-2">
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(2,'sleeves_short',this)">
                      <div><input type="radio" value="Short" name="sleeve" rel="Short"> Short</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/sleeve/sleeves-half-sleeves_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(2,'sleeves_full',this)">
                      <div><input type="radio" value="Long" checked="checked" name="sleeve" rel="Long"> Long </div>
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/sleeve/sleeves-full-sleeves_vector.jpg" alt=""></div>
                    </label>    
                  </li>
                  <li>
                    <label onclick="updateElements(2,'sleeves_rolled_up',this)">
                      <div><input type="radio" value="Rolled Up" name="sleeve" rel="Rolled Up"> Rolled Up </div>
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/sleeve/sleeves-rolledup-sleeves_vector.jpg" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-3">  
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(3,'collar_button_down',this)">
                      <div><input type="radio" value="Bottom Down" name="collar" rel="Bottom Down"> Bottom Down</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-button-down_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'collar_classic',this)">
                      <div><input type="radio" value="Classic" checked="checked" name="collar" rel="Classic"> Classic</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-classic_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'collar_short_spread',this)">
                      <div><input type="radio" value="Short Spread" name="collar" rel="Short Spread"> Short Spread</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-small-spread_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'collar_spread',this)">
                      <div><input type="radio" value="Spread" name="collar" rel="Spread"> Spread</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-spread_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'collar_tall_spread',this)">
                      <div><input type="radio" value="Tall Spread" name="collar" rel="Tall Spread"> Tall Spread</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-tall-spread_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'collar_chinese',this)">
                      <div><input type="radio" value="Chinese" name="collar" rel="Chinese"> Chinese</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/collar/collar-chinese_vector.jpg" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>
              
              <div id="tabs-4"> 
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(7,'single_button',this)">
                      <div><input type="radio" value="Single Button" name="cuff" checked="checked" rel="Single Button"> Single Button</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/cuff/cuffs-single-button_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(7,'double_button',this)">
                      <div><input type="radio" value="Double Button" name="cuff" rel="Double Button"> Double Button</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/cuff/cuffs-single-button_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(7,'french',this)">
                      <div><input type="radio" value="French cuff" name="cuff" rel="French cuff"> French cuff</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/cuff/cuffs-single-button_vector.jpg" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-5">  
                <h3>Placket</h3> 
                <label onclick="updateElements(10,'american',this)"><input type="radio" checked="checked" value="American" name="placket" rel="American"> American</label>
                <label onclick="updateElements(10,'french',this)"><input type="radio" value="French" name="placket" rel="French"> French</label>
                <label onclick="updateElements(10,'hidden',this)"><input type="radio" value="Hidden" name="placket" rel="Hidden"> Hidden</label>
              </div>

              <div id="tabs-6"> 
                <ul class="arrange_horizontal">
                  <li style="width:100%;">
                    <label>
                      <select name="pocket_type" onchange="updateElements(6,this.value,this)"><option value="0">None</option><option value="1" selected="selected">One</option><option value="2">Two</option></select>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'round',this)">
                      <div><input type="radio" value="Round" name="pocket" rel="Round"> Round</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/pocket/pocket-round-pocket_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'square',this)">
                      <div><input type="radio" value="Square" name="pocket" rel="Square"> Square</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/pocket/pocket-square-pocket_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'angled',this)">
                      <div><input type="radio" value="Angled" name="pocket" checked="checked" rel="Angled"> Angled</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/pocket/pocket-angled-pocket_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'vshape',this)">
                      <div><input type="radio" value="Vshape" name="pocket" rel="Vshape"> Vshape</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/pocket/pocket-vshaped-pocket_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'vshape_with_flap',this)">
                      <div><input type="radio" value="Flap" name="pocket" rel="Flap"> Flap</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/pocket/pocket-flap-pocket_vector.jpg" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-7"> 
                <h3>Back Detail</h3> 
                <li onclick="updateElements(8,'no_pleats',this)"><label><input type="radio" value="No Pleats" checked="checked" name="back_shirt" rel="No Pleats"> No Pleats</label></li>
                <li onclick="updateElements(8,'box_pleats',this)"><label><input type="radio" value="Box Pleat" name="back_shirt" rel="Box Pleat"> Box Pleat</label></li>
                <li onclick="updateElements(8,'side_pleats',this)"><label><input type="radio" value="Side Pleat" name="back_shirt" rel="Side Pleat"> Side Pleat</label></li>
              </div>

              <div id="tabs-8"> 
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(4,'front_shirt_bottom_long',this)">
                      <div><input type="radio" value="Round" checked="checked" name="front_shirt" rel="Round"> Round</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/front/bottomcut-round_vector.jpg" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(4,'front_shirt_bottom_straight',this)">
                      <div><input type="radio" value="Straight" name="front_shirt" rel="Straight"> Straight</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/s_customizations/front/bottomcut-straight_vector.jpg" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>
        </div>
    </div>
    <?php }else if($fabric_for==2){ ?>
    <div id="style" style="display:none;">
        <div id="tabs">
              <ul>
               <!--  <li><a href="#tabs-1">Fabric</a></li> -->
                <li><a href="#tabs-2">Belt</a></li>                
                <li><a href="#tabs-3">Pleats</a></li>
                <li><a href="#tabs-4">Side Pocket</a></li>
                <li><a href="#tabs-5">Back Pocket</a></li>
                <li><a href="#tabs-6">Bottom Style</a></li>
                <li><a href="#tabs-7">Trouser Lining</a></li>
                <!-- <li><a href="#tabs-8">Buttons</a></li> -->
              </ul>
              <div id="tabs-2">
                <li>
                    <label onclick="updateElements(2,'belt_button',this)">
                      <div><input type="radio" value="Belt Button" checked="checked" name="belt" rel="Belt Button" > Belt Button</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/belt/beltbutton_belt.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(2,'extended_belt_button',this)">
                      <div><input type="radio" value="Extended Belt Button" name="belt" rel="Extended Belt Button" > Extended Belt Button</div>
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/belt/extendedbeltbutton_belt.png" alt=""></div>
                    </label>    
                  </li>
              </div>

              <div id="tabs-3">  
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(3,'single_pleated',this)">
                      <div><input type="radio" value="Single Pleated" name="pleated" rel="Single Pleated" > Single Pleated</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/pleats/single_pleated.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'double_pleated',this)">
                      <div><input type="radio" value="Double Pleated" name="pleated" rel="Double Pleated" > Double Pleated</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/pleats/double_pleated.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(3,'flat_pleated',this)">
                      <div><input type="radio" value="Flat front Pleated" checked="checked" name="pleated" rel="Flat front Pleated" > Flat front Pleated</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/pleats/flatfront_pleated.png" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>
              
              <div id="tabs-4"> 
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(4,'slant_pocket',this)">
                      <div><input type="radio" value="Slant Pocket" checked="checked" name="sidepocket" rel="Slant Pocket" > Slant Pocket</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/sidepocket/slant_pocket.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(4,'straight_pocket',this)">
                      <div><input type="radio" value="Straight Pocket" name="sidepocket" rel="Straight Pocket"> Straight Pocket</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/sidepocket/straight_pocket.png" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-5">  
                <ul class="arrange_horizontal">
                  <li style="width:100%;">
                    <label>
                      <div><select name="back_pocket_type" onchange="updateElements(6,this.value)"><option value="0" selected="selected">None</option><option value="1">One</option><option value="2">Two</option></select> Round</div> </label>
                      <label onclick="updateElements(7,'flap',this)" ><div><input type="radio" value="Flap Pocket" checked="checked" name="backpocket" rel="Flap Pocket" > Flap Pocket</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/backpocket/flappocket_backpocket.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(7,'doublewelt',this)">
                      <div><input type="radio" value="Bouble Welp Pocket" name="backpocket" rel="Bouble Welp Pocket"> Bouble Welp Pocket</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/backpocket/doubleweltpocket_backpocket.png" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-6"> 
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(5,'straight_hem',this)">
                      <div><input type="radio" value="Straight Hem" checked="checked" name="bottomstyle" rel="Straight Hem"> Straight Hem</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/bottomstyle/straighthemtrouser_bottomstyle.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'shoe_cut',this)">
                      <div><input type="radio" value="Shoe cut" name="bottomstyle" rel="Shoe cut"> Shoe cut</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/bottomstyle/shoecut_bottomstyle.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(5,'turn_up',this)">
                      <div><input type="radio" value="Turn Up" name="bottomstyle" rel="Turn Up"> Turn Up</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/bottomstyle/turnup_bottomstyle.png" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>

              <div id="tabs-7"> 
                <ul class="arrange_horizontal">
                  <li>
                    <label onclick="updateElements(0,'lining',this)">
                      <div><input type="radio" value="No lining" checked="checked" name="lining" rel="No lining"> No lining</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/lining/no_lining.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(0,'lining',this)">
                      <div><input type="radio" value="Half front Lining" name="lining" rel="Half front Lining"> Half front Lining</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/lining/half_front_lining.png" alt=""></div>
                    </label>
                  </li>
                  <li>
                    <label onclick="updateElements(0,'lining',this)">
                      <div><input type="radio" value="Half front and Back Lining" name="lining" rel="Half front and Back Lining"> Half front and Back Lining</div> 
                      <div><img src="<?php echo Yii::app()->request->baseUrl;?>/storage/t_customizations/lining/half_front_and_back_lining.png" alt=""></div>
                    </label>
                  </li>
                </ul>
              </div>
        </div>
    </div>
    <?php } ?>
	

	<div id="buttons" style="display:none;">
		<ul class="buttons">
		  <?php      
		  $this->widget('zii.widgets.CListView', array(
		    'id'=>'buttons-grid',
		    'dataProvider'=>$buttons->search(),                       
		    'template'=>'{items}{pager}',        
		    'itemView'=>'_buttons',   
		    'summaryText'=>'Showing {start} to {end} of {count} entries',       
		  ));        
		  ?>
		</ul>
	</div>

</div>

<div style="width:58%;float:left;border:1px solid #ccc;min-height:500px;border-radius:5px;padding:5px;">
    <div class="main_inr_box_new">
        <div id="product_editor" class="editmyshirt"></div>
    </div>    
    <div class="view_summery_details">
        <h1>Summary</h1>
        <?php if($fabric_for==1){ ?>
        <form name="addtocart" id="addtocart" method="post" action="">
          <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>">
          <div>
            <ul>
              <li>
                <span><b>Fabric:</b></span>
                <span id="fabric"><?php echo $fabricDetail->fab_name; ?></span>
                <input type="hidden" name="txt_fabric" id="txt_fabric" value="<?php echo $id; ?>">
              </li>
              <li>
                <span><b>Sleeve:</b></span>
                <span id="sleeve"></span>
                <input type="hidden" name="txt_sleeve" id="txt_sleeve">
              </li>
              <li>
                <span><b>Collar:</b></span>
                <span id="collar"></span>
                <input type="hidden" name="txt_collor" id="txt_collar">
              </li>
              <li>
                <span><b>Cuff:</b></span>
                <span id="cuff"></span>
                <input type="hidden" name="txt_cuff" id="txt_cuff">
              </li>
              <li>
                <span><b>Placket:</b></span>
                <span id="placket"></span>
                <input type="hidden" name="txt_placket" id="txt_placket">
              </li>
              <li>
                <span><b>Pocket:</b></span>
                <span id="pocket"></span>
                <input type="hidden" name="txt_pocket" id="txt_pocket">
              </li>
              <li>
                <span><b>Back:</b></span>
                <span id="back_shirt"></span>
                <input type="hidden" name="txt_back_shirt" id="txt_back_shirt">
              </li>
              <li>
                <span><b>Bottom Cut:</b></span>
                <span id="front_shirt"></span>
                <input type="hidden" name="txt_front_shirt" id="txt_front_shirt">
              </li>
              <li>
                <span><b>Button:</b></span>
                <span id="button"></span>
                <input type="hidden" name="txt_button" id="txt_button">
              </li>
              <li>
                <span><b>Monogram:</b></span>
                <span id="monogram"></span>
                <input type="hidden" name="txt_monogram" id="txt_monogram">
              </li>
            </ul>
          </div>
        </form>
        <?php }else if($fabric_for==2){ ?>
        <form name="addtocart" id="addtocart" method="post" action="">
          <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>">
          <div>
            <ul>
              <li>
                <span><b>Fabric:</b></span>
                <span id="fabric"><?php echo $fabricDetail->fab_name; ?></span>
                <input type="hidden" name="txt_fabric" id="txt_fabric" value="<?php echo $id; ?>">
              </li>
              <li>
                <span><b>Belt:</b></span>
                <span id="belt"></span>
                <input type="hidden" name="txt_belt" id="txt_belt">
              </li>
              <li>
                <span><b>Pleated:</b></span>
                <span id="pleated"></span>
                <input type="hidden" name="txt_pleated" id="txt_pleated">
              </li>
              <li>
                <span><b>Side Pocket:</b></span>
                <span id="sidepocket"></span>
                <input type="hidden" name="txt_sidepocket" id="txt_sidepocket">
              </li>
              <li>
                <span><b>Back Pocket:</b></span>
                <span id="backpocket"></span>
                <input type="hidden" name="txt_backpocket" id="txt_backpocket">
              </li>
              <li>
                <span><b>Bottom Style:</b></span>
                <span id="bottomstyle"></span>
                <input type="hidden" name="txt_bottomstyle" id="txt_bottomstyle">
              </li>
              <li>
                <span><b>Lining:</b></span>
                <span id="lining"></span>
                <input type="hidden" name="txt_lining" id="txt_lining">
              </li>
              <li>
                <span><b>Button:</b></span>
                <span id="button"></span>
                <input type="hidden" name="txt_button" id="txt_button">
              </li>
            </ul>
          </div>
        </form>
        <?php } ?>
    </div>
</div>

<div>&nbsp;</div>

<div align="right">
  <input type="button" name="view_summery" id="view_summery" value="View Summary" class="btn btn-primary">
  <input type="button" name="add_to_cart" id="add_to_cart" value="Add to Cart" class="btn btn-primary">
</div>

<script type="text/javascript">
var indianStyloEditorJson = {fabricId:<?php echo $id;?>,buttonId:1};

$(document).ready(function(){
	$('.fabricTabs li').click(function(){
		$('.fabricTabs li').attr('class','');
		$(this).addClass('selected');
		var rel = $(this).attr('rel');
		$('#fabrics').hide();
		$('#style').hide();
		$('#buttons').hide();
		$('#'+rel).show();
	});

    $('.fabricClick').click(function(e){
      e.preventDefault();
      $('.fabricClick').parent().removeClass('selected');
      $(this).parent().addClass('selected');
      var id = $(this).attr('id');
      updateElements(1,id,this);
    });

    $('.buttonClick').click(function(){
      $('.buttonClick').parent().removeClass('selected');
      $(this).parent().addClass('selected');
      var id = $(this).attr('id');
      updateElements(11,id,this);
    });

    $('#fabric_patterns').change(function(){
      var value = $(this).val();
      $.fn.yiiListView.update(
          'fabrics-grid',
          {data: {'pattern' : value}}
      );
    });

    $('#fabric_all').change(function(){
      var value = $(this).val();
      $.fn.yiiListView.update(
          'fabrics-grid',
          {data: {'fabric' : value}}
      );
    });

    $('#fabric_colors').change(function(){
      var value = $(this).val();
      $.fn.yiiListView.update(
          'fabrics-grid',
          {data: {'color' : value}}
      );
    });

    $('#view_summery').click(function(){
      if($('.view_summery_details').is(':hidden')){
        $('.view_summery_details').show();
        $('.main_inr_box_new').hide();
        $(this).val('Hide Summary');
      }else{
        $('.view_summery_details').hide();
        $('.main_inr_box_new').show();
        $(this).val('View Summary');
      }
    });

    $('#add_to_cart').click(function(){
      $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->baseUrl; ?>/cart/addtocart',
        data:$('#addtocart').serialize(),
        success:function(data){
          console.log(data);
          if(data){
            var url = '<?php echo Yii::app()->baseUrl; ?>/cartitems';
            $('#cartModal').modal({
              remote:url
            });
          }
        },
      });
    });

    <?php if($fabric_for==1){ ?>
        setShirtDefaultOptions();
        indianStyloEditorObject = $("#product_editor").indianStyloSE(indianStyloEditorJson);
        $("#tabs").tabs({
            activate: function(event,ui){
                if(ui.newTab.index()==5){ 
                    indianStyloEditorObject.showRear(); 
                }else{ 
                    indianStyloEditorObject.showFront(); 
                } 
            }
        });
    <?php }else if($fabric_for==2){ ?>
        setTrouserDefaultOptions();
        indianStyloEditorObject = $("#product_editor").indianStyloTE(indianStyloEditorJson);
        $("#tabs").tabs({
            activate: function(event,ui){
                if(ui.newTab.index()==3){ 
                    indianStyloEditorObject.showRear(); 
                }else{ 
                    indianStyloEditorObject.showFront(); 
                } 
            }
        });
    <?php } ?>
});


function refreshImages(){
    indianStyloEditorObject.refreshFabricImages();
}

function setShirtDefaultOptions(){
    var val = $("input[type='radio'][name='front_shirt']:checked").val();
    $('.view_summery_details #front_shirt').text(val);
    $('.view_summery_details #txt_front_shirt').val(val);

    val = $("input[type='radio'][name='back_shirt']:checked").val();
    $('.view_summery_details #back_shirt').text(val);
    $('.view_summery_details #txt_back_shirt').val(val);

    val = $("input[type='radio'][name='pocket']:checked").val();
    $('.view_summery_details #pocket').text(val);
    $('.view_summery_details #txt_pocket').val(val);

    val = $("input[type='radio'][name='placket']:checked").val();
    $('.view_summery_details #placket').text(val);
    $('.view_summery_details #txt_placket').val(val);

    val = $("input[type='radio'][name='cuff']:checked").val();
    $('.view_summery_details #cuff').text(val);
    $('.view_summery_details #txt_cuff').val(val);

    val = $("input[type='radio'][name='collar']:checked").val();
    $('.view_summery_details #collar').text(val);
    $('.view_summery_details #txt_collar').val(val);

    val = $("input[type='radio'][name='sleeve']:checked").val();
    $('.view_summery_details #sleeve').text(val);
    $('.view_summery_details #txt_sleeve').val(val);
}
function setTrouserDefaultOptions(){
    var val = $("input[type='radio'][name='belt']:checked").val();
    $('.view_summery_details #belt').text(val);
    $('.view_summery_details #txt_belt').val(val);

    val = $("input[type='radio'][name='pleated']:checked").val();
    $('.view_summery_details #pleated').text(val);
    $('.view_summery_details #txt_pleated').val(val);

    val = $("input[type='radio'][name='sidepocket']:checked").val();
    $('.view_summery_details #sidepocket').text(val);
    $('.view_summery_details #txt_sidepocket').val(val);

    val = $("input[type='radio'][name='backpocket']:checked").val();
    $('.view_summery_details #backpocket').text(val);
    $('.view_summery_details #txt_backpocket').val(val);

    val = $("input[type='radio'][name='bottomstyle']:checked").val();
    $('.view_summery_details #bottomstyle').text(val);
    $('.view_summery_details #txt_bottomstyle').val(val);

    val = $("input[type='radio'][name='lining']:checked").val();
    $('.view_summery_details #lining').text(val);
    $('.view_summery_details #txt_lining').val(val);
}

<?php if($fabric_for==1){ ?>
    function updateElements(elem,newobj,obj){
        var text = $(obj).find('input').attr('rel');
        var name = $(obj).find('input').attr('name');
        $('.view_summery_details #'+name).text(text);
        $('.view_summery_details #txt_'+name).val(text);
        if($(obj).find('input').attr('fab_id')){
            $('.view_summery_details #txt_fabric').val($(obj).find('input').attr('fab_id'));  
        }
        if($(obj).find('input').attr('but_id')){
            $('.view_summery_details #txt_button').val($(obj).find('input').attr('but_id'));
        }
        switch(elem){
            case 1:
              indianStyloEditorObject.updateFabric(newobj);
            break;
            case 2:
              indianStyloEditorObject.updateSleeves(newobj);          
            break;
            case 3:
              indianStyloEditorObject.updateCollar(newobj);
            break;
            case 4:
              indianStyloEditorObject.updateFrontShirt(newobj);
            break;
            case 5:
              indianStyloEditorObject.updatePocket(newobj);
            break;
            case 6:
              indianStyloEditorObject.updatePocketVisibility(newobj);
            break;
            case 7:
              indianStyloEditorObject.updateCuff(newobj);
            break;
            case 8:
              indianStyloEditorObject.updateBackPleats(newobj);
            break;
            case 10:
              indianStyloEditorObject.updatePlacket(newobj);
            break;
            case 11:
              indianStyloEditorObject.updateButton(newobj);
            break;
        }
    }
<?php }else if($fabric_for==2){ ?>
    function updateElements(elem,newobj,obj){
        var text = $(obj).find('input').attr('rel');
        var name = $(obj).find('input').attr('name');
        $('.view_summery_details #'+name).text(text);
        $('.view_summery_details #txt_'+name).val(text);
        if($(obj).find('input').attr('fab_id')){
            $('.view_summery_details #txt_fabric').val($(obj).find('input').attr('fab_id'));  
        }
        if($(obj).find('input').attr('but_id')){
            $('.view_summery_details #txt_button').val($(obj).find('input').attr('but_id'));
        }
        switch(elem){
            case 1:
              indianStyloEditorObject.updateFabric(newobj);
            break;
            case 2:
              indianStyloEditorObject.updateBeltButton(newobj);
            break;
            case 3:
              indianStyloEditorObject.updatePleated(newobj);
            break;
            case 4:
              indianStyloEditorObject.updateSidePocket(newobj);
            break;
            case 5:
              indianStyloEditorObject.updateBottomStyle(newobj);
            break;
            case 6:
              indianStyloEditorObject.updatePocketVisibility(newobj);
            break;
            case 7:
              indianStyloEditorObject.updateBackPocket(newobj);
            break;
            case 8:
            case 11:
              indianStyloEditorObject.updateButton(newobj);
            break;
        }
    }
<?php } ?>

</script>