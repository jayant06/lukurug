<?php
class StringFilter extends CFilter{

    protected function preFilter($filterChain){      
        // logic being applied before the action is executed
		if(isset($_POST) && count($_POST)>0){
			$obj = new CHtmlPurifier();
			$obj->options = array('HTML.Allowed'=>'p,b,u,a[href|title],i,img[src|alt|title],em,strong,strike,ul,ol,li,div[align],br',
			'CSS.AllowedProperties' => array('text-decoration' => true,'font-family' => true,'font-size' => true,'text-align' => true,'padding-left' => true,'padding-right' => true,'padding-top' => true,'padding-bottom' => true,'color' => true,'background-color' => true),
			'AutoFormat.RemoveEmpty'=>true,
			);

			foreach($_POST as $key=>$val){
				if(is_array($val)){  
					$val = $obj->purify($val);
					//$_POST[$key] = Yii::app()->input->xssClean($val);
					$_POST[$key] = Yii::app()->input->xssClean($this->filterSubElement($val,$obj)); 
				}else{
					$_POST[$key] = $obj->purify($val);
				}
			}		  
		}	
		$filterChain->run();
        // return true; // false if the action should not be executed
    }
		
		protected function filterSubElement($arr=array(),$obj=''){
			if(count($arr)>0 && $obj!=''){
			 foreach($arr as $key2=>$val2){
				if ($key2!='ubsd_board_content'){
					if(is_array($val2)){
						$val2 = $obj->purify($val2);
						//$val2 = Yii::app()->input->xssClean($val2);
						$arr[$key2] = Yii::app()->input->xssClean($this->filterSubElement($val2,$obj));
					}else{
						$arr[$key2] = $obj->purify($val2);
						$arr[$key2] = preg_replace("/\s+/",' ', $val2);
					}
				 }
				}
			}
			return $arr;
		}
}
