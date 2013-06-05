<?php
namespace phpframework\components;

class HTMLText extends HTMLContainer{
	private $text = "";
	
	public function __construct($text = ""){
       parent::__construct($text);
	   $this->setTag("font");
	   
	   $this->setText($text);
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