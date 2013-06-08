<?php
namespace phpframework\components;

class HTMLButton extends HTMLInput{
	public function __construct($name = "Button", $value="true"){
       parent::__construct();
	   $this->addClassName("btn");
	   $this->setValue($name);
	   $this->setType("button");
	}
	public function isActive(){
		return (isset($_POST[$this->getName()]) and $_POST[$this->getName()] == $this->getValue());
	}
}
?>