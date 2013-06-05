<?php
namespace phpframework\components;

class HTMLTitle extends HTMLText{
	
	public function __construct($text = ""){
       parent::__construct($text);
	   $this->setTag("h4");
	   $this->addClassName("brand");
	}
}
?>