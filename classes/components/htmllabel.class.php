<?php
namespace phpframework\components;

class HTMLLabel extends HTMLComponent{
	protected function getTagName(){
		return "label";
	}
	public function setField(HTMLComponent $component){
		$this->setAttribute("for", $component->getElementId());
	}
}
?>