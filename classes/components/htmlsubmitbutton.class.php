<?php
class HTMLSubmitButton extends HTMLButton{	
	public function __construct($text = "Button", $name = "", $value="true"){
       parent::__construct($text, $name, $value, "submit");
	}
}
?>