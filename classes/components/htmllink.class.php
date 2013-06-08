<?php
namespace phpframework\components;

class HTMLLink extends HTMLText{
	protected function getTagName(){
		return "a";
	}
	public function __construct($link){
		parent::__construct();
		$this->setLink($link);
	}
	public function getLink(){
		return $this->getAttribute("href");
	}
	public function setLink($link){
		$this->addAttribute("href",$link);
	}
}
?>