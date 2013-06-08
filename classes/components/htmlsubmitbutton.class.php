<?php
namespace phpframework\components;

class HTMLSubmitButton extends HTMLButton{	
	public function __construct($name = "Button", $value="true"){
       parent::__construct($name, $value);
	   $this->setType("submit");
	}
}
?>