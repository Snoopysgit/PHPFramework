<?php
namespace phpframework\components;

class HTMLText extends HTMLContainer{
	protected function getTagName(){
		return "font";
	}
	public function setText($text){
		$this->removeAllContent();
		$this->addContent($text);
	}
	public function getText(){
		return $this->getContent(0);
	}
}
?>