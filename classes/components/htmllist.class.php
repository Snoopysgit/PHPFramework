<?php
namespace phpframework\components;

class HTMLList extends HTMLComponent{
	protected function getTagName(){
		return "ul";
	}
}
class HTMLListItem extends HTMLComponent{
	protected function getTagName(){
		return "li";
	}
	public function setActive($active){
		if($active){
			$this->addClassName("active");
		}else{
			$this->removeClassName("active");
		}
	}
}
?>