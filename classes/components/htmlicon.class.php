<?php
namespace phpframework\components;

class HTMLIcon extends HTMLComponent{	
	public function __construct($icon = ""){
       parent::__construct();
	   $this->setTag("i");
	   $this->addClassName($icon);
	}
	public function refreshHTML(){
		// icons haben keinen inhalt
	}
}
?>