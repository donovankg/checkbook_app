<?php
class Utils{
	

	function create_select_box($name, $options, $selected_value){
		//echo ("test");
		$str = "<select name ='$name' id='$name'>";
		foreach ($options as $opt) {
			
			$value = $opt['value'];
			$text = $opt['text'];
			$attr ="";
			if((int)$selected_value== (int)$value){
				$attr =" selected=true ";
			}
			$str .="<option value ='$value' $attr>$text</option>";
		}
		$str .= "</select>";
		return $str;
	}

	function encrypt_password($password){
	
		$salt ="aps%&!";
		return $salt.md5($password).$salt;

	}

}
