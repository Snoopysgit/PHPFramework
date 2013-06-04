<?php
class HTMLLabel extends HTMLText{
	
	public function __construct($text = ""){
       parent::__construct($text);
	   $this->setTag("label");
	}
	public function setField(HTMLComponent $component){
		$this->setAttribute("for", $component->getElementId());
	}
}
?>