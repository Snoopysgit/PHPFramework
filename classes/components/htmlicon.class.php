<?php
namespace phpframework\components;

class HTMLIcon extends HTMLComponent{
	protected function getTagName(){
		return "i";
	}
	public function __construct($icon = ""){
       parent::__construct();
	   $this->addClassName($icon);
	}
}
?>